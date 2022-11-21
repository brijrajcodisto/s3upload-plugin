<?php

namespace BaghelSoft\S3Uploads\Aws\Retry\Exception;

use BaghelSoft\S3Uploads\Aws\HasMonitoringEventsTrait;
use BaghelSoft\S3Uploads\Aws\MonitoringEventsInterface;
/**
 * Represents an error interacting with retry configuration
 */
class ConfigurationException extends \RuntimeException implements \BaghelSoft\S3Uploads\Aws\MonitoringEventsInterface
{
    use HasMonitoringEventsTrait;
}
