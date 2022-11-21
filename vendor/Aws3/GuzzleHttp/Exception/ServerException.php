<?php

namespace BaghelSoft\S3Uploads\GuzzleHttp\Exception;

/**
 * Exception when a server error is encountered (5xx codes)
 */
class ServerException extends \BaghelSoft\S3Uploads\GuzzleHttp\Exception\BadResponseException
{
}
