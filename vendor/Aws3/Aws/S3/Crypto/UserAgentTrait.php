<?php

namespace BaghelSoft\S3Uploads\Aws\S3\Crypto;

use BaghelSoft\S3Uploads\Aws\AwsClientInterface;
use BaghelSoft\S3Uploads\Aws\Middleware;
use BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface;
trait UserAgentTrait
{
    private function appendUserAgent(\BaghelSoft\S3Uploads\Aws\AwsClientInterface $client, $agentString)
    {
        $list = $client->getHandlerList();
        $list->appendBuild(\BaghelSoft\S3Uploads\Aws\Middleware::mapRequest(function (\BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface $req) use($agentString) {
            if (!empty($req->getHeader('User-Agent')) && !empty($req->getHeader('User-Agent')[0])) {
                $userAgent = $req->getHeader('User-Agent')[0];
                if (strpos($userAgent, $agentString) === false) {
                    $userAgent .= " {$agentString}";
                }
            } else {
                $userAgent = $agentString;
            }
            $req = $req->withHeader('User-Agent', $userAgent);
            return $req;
        }));
    }
}
