<?php

namespace BaghelSoft\S3Uploads\Aws\Api\Parser;

use BaghelSoft\S3Uploads\Aws\Api\StructureShape;
use BaghelSoft\S3Uploads\Aws\CommandInterface;
use BaghelSoft\S3Uploads\Aws\Exception\AwsException;
use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface;
use BaghelSoft\S3Uploads\GuzzleHttp\Psr7;
/**
 * @internal Decorates a parser and validates the x-amz-crc32 header.
 */
class Crc32ValidatingParser extends \BaghelSoft\S3Uploads\Aws\Api\Parser\AbstractParser
{
    /**
     * @param callable $parser Parser to wrap.
     */
    public function __construct(callable $parser)
    {
        $this->parser = $parser;
    }
    public function __invoke(\BaghelSoft\S3Uploads\Aws\CommandInterface $command, \BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface $response)
    {
        if ($expected = $response->getHeaderLine('x-amz-crc32')) {
            $hash = hexdec(\BaghelSoft\S3Uploads\GuzzleHttp\Psr7\hash($response->getBody(), 'crc32b'));
            if ($expected != $hash) {
                throw new \BaghelSoft\S3Uploads\Aws\Exception\AwsException("crc32 mismatch. Expected {$expected}, found {$hash}.", $command, ['code' => 'ClientChecksumMismatch', 'connection_error' => true, 'response' => $response]);
            }
        }
        $fn = $this->parser;
        return $fn($command, $response);
    }
    public function parseMemberFromStream(\BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface $stream, \BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, $response)
    {
        return $this->parser->parseMemberFromStream($stream, $member, $response);
    }
}
