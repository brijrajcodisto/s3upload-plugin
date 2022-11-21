<?php

namespace BaghelSoft\S3Uploads\Aws\Api\Parser;

use BaghelSoft\S3Uploads\Aws\Api\Service;
use BaghelSoft\S3Uploads\Aws\Api\StructureShape;
use BaghelSoft\S3Uploads\Aws\Result;
use BaghelSoft\S3Uploads\Aws\CommandInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface;
/**
 * @internal Parses query (XML) responses (e.g., EC2, SQS, and many others)
 */
class QueryParser extends \BaghelSoft\S3Uploads\Aws\Api\Parser\AbstractParser
{
    use PayloadParserTrait;
    /** @var bool */
    private $honorResultWrapper;
    /**
     * @param Service   $api                Service description
     * @param XmlParser $xmlParser          Optional XML parser
     * @param bool      $honorResultWrapper Set to false to disable the peeling
     *                                      back of result wrappers from the
     *                                      output structure.
     */
    public function __construct(\BaghelSoft\S3Uploads\Aws\Api\Service $api, \BaghelSoft\S3Uploads\Aws\Api\Parser\XmlParser $xmlParser = null, $honorResultWrapper = true)
    {
        parent::__construct($api);
        $this->parser = $xmlParser ?: new \BaghelSoft\S3Uploads\Aws\Api\Parser\XmlParser();
        $this->honorResultWrapper = $honorResultWrapper;
    }
    public function __invoke(\BaghelSoft\S3Uploads\Aws\CommandInterface $command, \BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface $response)
    {
        $output = $this->api->getOperation($command->getName())->getOutput();
        $xml = $this->parseXml($response->getBody(), $response);
        if ($this->honorResultWrapper && $output['resultWrapper']) {
            $xml = $xml->{$output['resultWrapper']};
        }
        return new \BaghelSoft\S3Uploads\Aws\Result($this->parser->parse($output, $xml));
    }
    public function parseMemberFromStream(\BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface $stream, \BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, $response)
    {
        $xml = $this->parseXml($stream, $response);
        return $this->parser->parse($member, $xml);
    }
}
