<?php

namespace BaghelSoft\S3Uploads\Aws\Api\Serializer;

use BaghelSoft\S3Uploads\Aws\Api\StructureShape;
use BaghelSoft\S3Uploads\Aws\Api\Service;
/**
 * @internal
 */
class RestXmlSerializer extends \BaghelSoft\S3Uploads\Aws\Api\Serializer\RestSerializer
{
    /** @var XmlBody */
    private $xmlBody;
    /**
     * @param Service $api      Service API description
     * @param string  $endpoint Endpoint to connect to
     * @param XmlBody $xmlBody  Optional XML formatter to use
     */
    public function __construct(\BaghelSoft\S3Uploads\Aws\Api\Service $api, $endpoint, \BaghelSoft\S3Uploads\Aws\Api\Serializer\XmlBody $xmlBody = null)
    {
        parent::__construct($api, $endpoint);
        $this->xmlBody = $xmlBody ?: new \BaghelSoft\S3Uploads\Aws\Api\Serializer\XmlBody($api);
    }
    protected function payload(\BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, array $value, array &$opts)
    {
        $opts['headers']['Content-Type'] = 'application/xml';
        $opts['body'] = (string) $this->xmlBody->build($member, $value);
    }
}
