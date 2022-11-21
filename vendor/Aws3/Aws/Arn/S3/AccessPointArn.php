<?php

namespace BaghelSoft\S3Uploads\Aws\Arn\S3;

use BaghelSoft\S3Uploads\Aws\Arn\AccessPointArn as BaseAccessPointArn;
use BaghelSoft\S3Uploads\Aws\Arn\AccessPointArnInterface;
use BaghelSoft\S3Uploads\Aws\Arn\ArnInterface;
use BaghelSoft\S3Uploads\Aws\Arn\Exception\InvalidArnException;
/**
 * @internal
 */
class AccessPointArn extends \BaghelSoft\S3Uploads\Aws\Arn\AccessPointArn implements \BaghelSoft\S3Uploads\Aws\Arn\AccessPointArnInterface
{
    /**
     * Validation specific to AccessPointArn
     *
     * @param array $data
     */
    protected static function validate(array $data)
    {
        parent::validate($data);
        if ($data['service'] !== 's3') {
            throw new \BaghelSoft\S3Uploads\Aws\Arn\Exception\InvalidArnException("The 3rd component of an S3 access" . " point ARN represents the region and must be 's3'.");
        }
    }
}
