<?php

namespace BaghelSoft\S3Uploads\Aws\Exception;

use BaghelSoft\S3Uploads\Aws\HasMonitoringEventsTrait;
use BaghelSoft\S3Uploads\Aws\MonitoringEventsInterface;
class CredentialsException extends \RuntimeException implements \BaghelSoft\S3Uploads\Aws\MonitoringEventsInterface
{
    use HasMonitoringEventsTrait;
}
