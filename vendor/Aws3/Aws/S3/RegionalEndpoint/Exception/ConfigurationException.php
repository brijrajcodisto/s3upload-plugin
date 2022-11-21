<?php

namespace BaghelSoft\S3Uploads\Aws\S3\RegionalEndpoint\Exception;

use BaghelSoft\S3Uploads\Aws\HasMonitoringEventsTrait;
use BaghelSoft\S3Uploads\Aws\MonitoringEventsInterface;
/**
 * Represents an error interacting with configuration for sts regional endpoints
 */
class ConfigurationException extends \RuntimeException implements \BaghelSoft\S3Uploads\Aws\MonitoringEventsInterface
{
    use HasMonitoringEventsTrait;
}
