<?php
/*
 * Plugin Name: S3Uploads
 * Description: This is a plugin to sync your uploads to cloud.
 * Author: S3Uploads
 * Author URI: https://s3uploads.com
 * Text Domain: s3uploads
 * Requires at least: 5.3
 * Requires PHP: 7.1
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network: true
 *
 * Inspired by S3 Uploads plugin by Human Made https://github.com/humanmade/S3-Uploads.
 *
 * Copyright 2022 baghelsoft.com™
*/

define( 'S3UPLOADS_VERSION', '1.1.5' );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once dirname( __FILE__ ) . '/inc/class-s3uploads-wp-cli-command.php';
}

register_activation_hook( __FILE__, 's3uploads_install' );

add_action( 'plugins_loaded', 's3uploads_init' );

function s3uploads_init() {

	//how much to try uploading/downloading per ajax loop (we want as much as possible without exceeding (php timeout - ajax_timeout) to avoid 504s
	if ( ! defined( 'S3UPLOADS_SYNC_MAX_BYTES' ) ) {
		define( 'S3UPLOADS_SYNC_MAX_BYTES', MB_IN_BYTES * 5 );
	}
	//This is the maximum to transfer in parallel within the S3UPLOADS_SYNC_MAX_BYTES size.
	if ( ! defined( 'S3UPLOADS_SYNC_CONCURRENCY' ) ) {
		define( 'S3UPLOADS_SYNC_CONCURRENCY', 15 );
	}
	if ( ! defined( 'S3UPLOADS_SYNC_MULTIPART_CONCURRENCY' ) ) {
		define( 'S3UPLOADS_SYNC_MULTIPART_CONCURRENCY', 5 );
	}
	if ( ! defined( 'S3UPLOADS_SYNC_PER_LOOP' ) ) {
		define( 'S3UPLOADS_SYNC_PER_LOOP', 1000 );
	}
	if ( ! defined( 'S3UPLOADS_HTTP_CACHE_CONTROL' ) ) {
		define( 'S3UPLOADS_HTTP_CACHE_CONTROL', YEAR_IN_SECONDS );
	}
	//we cache the last object uploaded to cloud in memory so it can be processed without downloading again.
	if ( ! defined( 'S3UPLOADS_STREAM_CACHE_MAX_BYTES' ) ) {
		define( 'S3UPLOADS_STREAM_CACHE_MAX_BYTES', MB_IN_BYTES * 32 );
	}

	// Require Our custom AWS Autoloader file.
	require_once dirname( __FILE__ ) . '/vendor/Aws3/aws-autoloader.php';

	if ( ! s3uploads_check_requirements() ) {
		return;
	}

	s3uploads_upgrade();

	$instance = S3Uploads::get_instance();
	$instance->setup();
}

function s3uploads_upgrade() {

	// Install the needed DB table if not already.
	$installed = get_site_option( 'iup_installed' );
	if ( S3UPLOADS_VERSION != $installed ) {
		s3uploads_install();
	}
}

function s3uploads_install() {
	global $wpdb;

	//prevent race condition during upgrade by setting option before running potentially long query
	if ( is_multisite() ) {
		update_site_option( 'iup_installed', S3UPLOADS_VERSION );
	} else {
		update_option( 'iup_installed', S3UPLOADS_VERSION, true );
	}

	$charset_collate = $wpdb->get_charset_collate();

	//191 is the maximum innodb default key length on utf8mb4
	$sql = "CREATE TABLE {$wpdb->base_prefix}s3uploads_files (
            `file` VARCHAR(255) NOT NULL,
            `size` BIGINT UNSIGNED NOT NULL DEFAULT '0',
            `modified` INT UNSIGNED NOT NULL,
            `type` VARCHAR(20) NOT NULL,
            `transferred` BIGINT UNSIGNED NOT NULL DEFAULT '0',
            `synced` BOOLEAN NOT NULL DEFAULT '0',
            `deleted` BOOLEAN NOT NULL DEFAULT '0',
            `errors` INT UNSIGNED NOT NULL DEFAULT '0',
            `transfer_status` TEXT NULL DEFAULT NULL,
            PRIMARY KEY  (`file`(191)),
            KEY `type` (`type`),
            KEY `synced` (`synced`),
            KEY `deleted` (`deleted`)
        ) {$charset_collate};";

	if ( ! function_exists( 'dbDelta' ) ) {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	}

	return dbDelta( $sql );
}

/**
 * Check whether the environment meets the plugin's requirements, like the minimum PHP version.
 *
 * @return bool True if the requirements are met, else false.
 */
function s3uploads_check_requirements() {
	global $wp_version;
	$hook = is_multisite() ? 'network_admin_notices' : 'admin_notices';

	if ( version_compare( PHP_VERSION, '5.5.0', '<' ) ) {
		add_action( $hook, 's3uploads_outdated_php_version_notice' );

		return false;
	}

	if ( version_compare( $wp_version, '5.3.0', '<' ) ) {
		add_action( $hook, 's3uploads_outdated_wp_version_notice' );

		return false;
	}

	return true;
}

/**
 * Print an admin notice when the PHP version is not high enough.
 *
 * This has to be a named function for compatibility with PHP 5.2.
 */
function s3uploads_outdated_php_version_notice() {
	?>
	<div class="notice notice-warning is-dismissible"><p>
			<?php printf( esc_html__( 'The s3Uploads plugin requires PHP version 5.5.0 or higher. Your server is running PHP version %s.', 's3uploads' ), PHP_VERSION ); ?>
		</p></div>
	<?php
}

/**
 * Print an admin notice when the WP version is not high enough.
 *
 * This has to be a named function for compatibility with PHP 5.2.
 */
function s3uploads_outdated_wp_version_notice() {
	global $wp_version;
	?>
	<div class="notice notice-warning is-dismissible"><p>
			<?php printf( esc_html__( 'The s3Uploads plugin requires WordPress version 5.3 or higher. Your server is running WordPress version %s.', 's3uploads' ), $wp_version ); ?>
		</p></div>
	<?php
}

/**
 * Check if URL rewriting is enabled.
 *
 * @return bool
 */
function s3uploads_enabled() {
	return get_site_option( 'iup_enabled' );
}

/**
 * Autoload callback.
 *
 * @param $class_name string Name of the class to load.
 */
function s3uploads_autoload( $class_name ) {
	/*
	 * Load plugin classes:
	 * - Class name: S3Uploads_Image_Editor_Imagick.
	 * - File name: class-s3uploads-image-editor-imagick.php.
	 */
	$class_file = 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';
	$class_path = dirname( __FILE__ ) . '/inc/' . $class_file;

	if ( file_exists( $class_path ) ) {
		require $class_path;

		return;
	}
}

spl_autoload_register( 's3uploads_autoload' );

