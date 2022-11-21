<?php

namespace BaghelSoft\S3Uploads\Aws\S3\UseArnRegion;

use Aws;
use BaghelSoft\S3Uploads\Aws\S3\UseArnRegion\Exception\ConfigurationException;
class Configuration implements \BaghelSoft\S3Uploads\Aws\S3\UseArnRegion\ConfigurationInterface
{
    private $useArnRegion;
    public function __construct($useArnRegion)
    {
        $this->useArnRegion = \BaghelSoft\S3Uploads\Aws\boolean_value($useArnRegion);
        if (is_null($this->useArnRegion)) {
            throw new \BaghelSoft\S3Uploads\Aws\S3\UseArnRegion\Exception\ConfigurationException("'use_arn_region' config option" . " must be a boolean value.");
        }
    }
    /**
     * {@inheritdoc}
     */
    public function isUseArnRegion()
    {
        return $this->useArnRegion;
    }
    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return ['use_arn_region' => $this->isUseArnRegion()];
    }
}
