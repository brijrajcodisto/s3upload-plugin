<?php

namespace BaghelSoft\S3Uploads\Aws\Handler\GuzzleV5;

use BaghelSoft\S3Uploads\GuzzleHttp\Stream\StreamDecoratorTrait;
use BaghelSoft\S3Uploads\GuzzleHttp\Stream\StreamInterface as GuzzleStreamInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface as Psr7StreamInterface;
/**
 * Adapts a PSR-7 Stream to a Guzzle 5 Stream.
 *
 * @codeCoverageIgnore
 */
class GuzzleStream implements \BaghelSoft\S3Uploads\GuzzleHttp\Stream\StreamInterface
{
    use StreamDecoratorTrait;
    /** @var Psr7StreamInterface */
    private $stream;
    public function __construct(\BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface $stream)
    {
        $this->stream = $stream;
    }
}
