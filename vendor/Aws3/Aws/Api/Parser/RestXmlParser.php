<?php

namespace BaghelSoft\S3Uploads\Aws\Api\Parser;

use BaghelSoft\S3Uploads\Aws\Api\StructureShape;
use BaghelSoft\S3Uploads\Aws\Api\Service;
use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface;
/**
 * @internal Implements REST-XML parsing (e.g., S3, CloudFront, etc...)
 */
class RestXmlParser extends \BaghelSoft\S3Uploads\Aws\Api\Parser\AbstractRestParser
{
    use PayloadParserTrait;
    /**
     * @param Service   $api    Service description
     * @param XmlParser $parser XML body parser
     */
    public function __construct(\BaghelSoft\S3Uploads\Aws\Api\Service $api, \BaghelSoft\S3Uploads\Aws\Api\Parser\XmlParser $parser = null)
    {
        parent::__construct($api);
        $this->parser = $parser ?: new \BaghelSoft\S3Uploads\Aws\Api\Parser\XmlParser();
    }
    protected function payload(\BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface $response, \BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, array &$result)
    {
        $result += $this->parseMemberFromStream($response->getBody(), $member, $response);
    }
    public function parseMemberFromStream(\BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface $stream, \BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, $response)
    {
        $xml = $this->parseXml($stream, $response);
        return $this->parser->parse($member, $xml);
    }
}
