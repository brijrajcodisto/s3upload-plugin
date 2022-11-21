<?php

namespace BaghelSoft\S3Uploads\Aws\Api\Serializer;

use BaghelSoft\S3Uploads\Aws\Api\Shape;
use BaghelSoft\S3Uploads\Aws\Api\ListShape;
/**
 * @internal
 */
class Ec2ParamBuilder extends \BaghelSoft\S3Uploads\Aws\Api\Serializer\QueryParamBuilder
{
    protected function queryName(\BaghelSoft\S3Uploads\Aws\Api\Shape $shape, $default = null)
    {
        return $shape['queryName'] ?: ucfirst($shape['locationName']) ?: $default;
    }
    protected function isFlat(\BaghelSoft\S3Uploads\Aws\Api\Shape $shape)
    {
        return false;
    }
    protected function format_list(\BaghelSoft\S3Uploads\Aws\Api\ListShape $shape, array $value, $prefix, &$query)
    {
        // Handle empty list serialization
        if (!$value) {
            $query[$prefix] = false;
        } else {
            $items = $shape->getMember();
            foreach ($value as $k => $v) {
                $this->format($items, $v, $prefix . '.' . ($k + 1), $query);
            }
        }
    }
}
