<?php

namespace BaghelSoft\S3Uploads\Aws\Api\Parser;

use BaghelSoft\S3Uploads\Aws\Api\Service;
use BaghelSoft\S3Uploads\Aws\Api\StructureShape;
use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface;
/**
 * @internal Implements REST-JSON parsing (e.g., Glacier, Elastic Transcoder)
 */
class RestJsonParser extends \BaghelSoft\S3Uploads\Aws\Api\Parser\AbstractRestParser
{
    use PayloadParserTrait;
    /**
     * @param Service    $api    Service description
     * @param JsonParser $parser JSON body builder
     */
    public function __construct(\BaghelSoft\S3Uploads\Aws\Api\Service $api, \BaghelSoft\S3Uploads\Aws\Api\Parser\JsonParser $parser = null)
    {
        parent::__construct($api);
        $this->parser = $parser ?: new \BaghelSoft\S3Uploads\Aws\Api\Parser\JsonParser();
    }
    protected function payload(\BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface $response, \BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, array &$result)
    {
        $jsonBody = $this->parseJson($response->getBody(), $response);
        if ($jsonBody) {
            $result += $this->parser->parse($member, $jsonBody);
        }
    }
    public function parseMemberFromStream(\BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface $stream, \BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, $response)
    {
        $jsonBody = $this->parseJson($stream, $response);
        if ($jsonBody) {
            return $this->parser->parse($member, $jsonBody);
        }
        return [];
    }
}
