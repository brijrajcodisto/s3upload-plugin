<?php

namespace BaghelSoft\S3Uploads\JmesPath;

/**
 * Returns data from the input array that matches a JMESPath expression.
 *
 * @param string $expression Expression to search.
 * @param mixed $data Data to search.
 *
 * @return mixed
 */
if (!function_exists(__NAMESPACE__ . '\\search')) {
    function search($expression, $data)
    {
        return \BaghelSoft\S3Uploads\JmesPath\Env::search($expression, $data);
    }
}
