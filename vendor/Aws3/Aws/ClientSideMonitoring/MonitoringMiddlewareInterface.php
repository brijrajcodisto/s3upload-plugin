<?php

namespace BaghelSoft\S3Uploads\Aws\ClientSideMonitoring;

use BaghelSoft\S3Uploads\Aws\CommandInterface;
use BaghelSoft\S3Uploads\Aws\Exception\AwsException;
use BaghelSoft\S3Uploads\Aws\ResultInterface;
use BaghelSoft\S3Uploads\GuzzleHttp\Psr7\Request;
use BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface;
/**
 * @internal
 */
interface MonitoringMiddlewareInterface
{
    /**
     * Data for event properties to be sent to the monitoring agent.
     *
     * @param RequestInterface $request
     * @return array
     */
    public static function getRequestData(\BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface $request);
    /**
     * Data for event properties to be sent to the monitoring agent.
     *
     * @param ResultInterface|AwsException|\Exception $klass
     * @return array
     */
    public static function getResponseData($klass);
    public function __invoke(\BaghelSoft\S3Uploads\Aws\CommandInterface $cmd, \BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface $request);
}
