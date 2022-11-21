<?php

namespace BaghelSoft\S3Uploads\GuzzleHttp\Promise;

/**
 * Exception that is set as the reason for a promise that has been cancelled.
 */
class CancellationException extends \BaghelSoft\S3Uploads\GuzzleHttp\Promise\RejectionException
{
}
