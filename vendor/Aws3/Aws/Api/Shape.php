<?php

namespace BaghelSoft\S3Uploads\Aws\Api;

/**
 * Base class representing a modeled shape.
 */
class Shape extends \BaghelSoft\S3Uploads\Aws\Api\AbstractModel
{
    /**
     * Get a concrete shape for the given definition.
     *
     * @param array    $definition
     * @param ShapeMap $shapeMap
     *
     * @return mixed
     * @throws \RuntimeException if the type is invalid
     */
    public static function create(array $definition, \BaghelSoft\S3Uploads\Aws\Api\ShapeMap $shapeMap)
    {
        static $map = ['structure' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\StructureShape', 'map' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\MapShape', 'list' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\ListShape', 'timestamp' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\TimestampShape', 'integer' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape', 'double' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape', 'float' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape', 'long' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape', 'string' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape', 'byte' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape', 'character' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape', 'blob' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape', 'boolean' => 'BaghelSoft\\S3Uploads\\Aws\\Api\\Shape'];
        if (isset($definition['shape'])) {
            return $shapeMap->resolve($definition);
        }
        if (!isset($map[$definition['type']])) {
            throw new \RuntimeException('Invalid type: ' . print_r($definition, true));
        }
        $type = $map[$definition['type']];
        return new $type($definition, $shapeMap);
    }
    /**
     * Get the type of the shape
     *
     * @return string
     */
    public function getType()
    {
        return $this->definition['type'];
    }
    /**
     * Get the name of the shape
     *
     * @return string
     */
    public function getName()
    {
        return $this->definition['name'];
    }
}
