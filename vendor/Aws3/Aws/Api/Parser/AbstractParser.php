<?php

namespace BaghelSoft\S3Uploads\Aws\Api\Parser;

use BaghelSoft\S3Uploads\Aws\Api\Service;
use BaghelSoft\S3Uploads\Aws\Api\StructureShape;
use BaghelSoft\S3Uploads\Aws\CommandInterface;
use BaghelSoft\S3Uploads\Aws\ResultInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface;
/**
 * @internal
 */
abstract class AbstractParser
{
    /** @var \Aws\Api\Service Representation of the service API*/
    protected $api;
    /** @var callable */
    protected $parser;
    /**
     * @param Service $api Service description.
     */
    public function __construct(\BaghelSoft\S3Uploads\Aws\Api\Service $api)
    {
        $this->api = $api;
    }
    /**
     * @param CommandInterface  $command  Command that was executed.
     * @param ResponseInterface $response Response that was received.
     *
     * @return ResultInterface
     */
    public abstract function __invoke(\BaghelSoft\S3Uploads\Aws\CommandInterface $command, \BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface $response);
    public abstract function parseMemberFromStream(\BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface $stream, \BaghelSoft\S3Uploads\Aws\Api\StructureShape $member, $response);
}
