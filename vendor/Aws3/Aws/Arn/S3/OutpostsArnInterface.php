<?php

namespace BaghelSoft\S3Uploads\Aws\Arn\S3;

use BaghelSoft\S3Uploads\Aws\Arn\ArnInterface;
/**
 * @internal
 */
interface OutpostsArnInterface extends ArnInterface
{
    public function getOutpostId();
}
