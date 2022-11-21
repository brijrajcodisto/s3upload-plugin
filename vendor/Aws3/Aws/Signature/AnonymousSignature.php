<?php

namespace BaghelSoft\S3Uploads\Aws\Signature;

use BaghelSoft\S3Uploads\Aws\Credentials\CredentialsInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface;
/**
 * Provides anonymous client access (does not sign requests).
 */
class AnonymousSignature implements \BaghelSoft\S3Uploads\Aws\Signature\SignatureInterface
{
    /**
     * /** {@inheritdoc}
     */
    public function signRequest(\BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface $request, \BaghelSoft\S3Uploads\Aws\Credentials\CredentialsInterface $credentials)
    {
        return $request;
    }
    /**
     * /** {@inheritdoc}
     */
    public function presign(\BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface $request, \BaghelSoft\S3Uploads\Aws\Credentials\CredentialsInterface $credentials, $expires, array $options = [])
    {
        return $request;
    }
}
