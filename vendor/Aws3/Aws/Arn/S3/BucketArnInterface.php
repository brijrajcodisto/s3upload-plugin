<?php

namespace BaghelSoft\S3Uploads\Aws\Arn\S3;

use BaghelSoft\S3Uploads\Aws\Arn\ArnInterface;
/**
 * @internal
 */
interface BucketArnInterface extends ArnInterface
{
    public function getBucketName();
}
