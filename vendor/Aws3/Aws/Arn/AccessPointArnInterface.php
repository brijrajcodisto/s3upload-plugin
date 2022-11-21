<?php

namespace BaghelSoft\S3Uploads\Aws\Arn;

/**
 * @internal
 */
interface AccessPointArnInterface extends ArnInterface
{
    public function getAccesspointName();
}
