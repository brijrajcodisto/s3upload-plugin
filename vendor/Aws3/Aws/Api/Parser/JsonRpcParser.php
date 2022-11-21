<?php

namespace BaghelSoft\S3Uploads\Aws\Api\Parser;

use BaghelSoft\S3Uploads\Aws\Api\StructureShape;
use BaghelSoft\S3Uploads\Aws\Api\Service;
use BaghelSoft\S3Uploads\Aws\Result;
use BaghelSoft\S3Uploads\Aws\CommandInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface;
/**
 * @internal Implements JSON-RPC parsing (e.g., DynamoDB)
 */
class JsonRpcParser extends \BaghelSoft\S3Uploads\Aws\Api\Parser\AbstractParser
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
    public function __invoke(\BaghelSoft\S3Uploads\Aws\CommandInterface $command, \BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface $response)
    {
        $operation = $this->api->getOperation($command->getName());
        $result = null === $operation['output'] ? null : $this->parseMemberFromStream($response->getBody(), $operation->getOutput(), $response);
        return new \BaghelSoft\S3Uploads\Aws\Result($result ?: []);
    }
    public function parseMemberFromStream(\BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface $stream, \BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, $response)
    {
        return $this->parser->parse($member, $this->parseJson($stream, $response));
    }
}
