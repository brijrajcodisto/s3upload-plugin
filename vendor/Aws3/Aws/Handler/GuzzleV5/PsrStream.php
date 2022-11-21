<?php

namespace BaghelSoft\S3Uploads\Aws\Handler\GuzzleV5;

use BaghelSoft\S3Uploads\GuzzleHttp\Stream\StreamDecoratorTrait;
use BaghelSoft\S3Uploads\GuzzleHttp\Stream\StreamInterface as GuzzleStreamInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface as Psr7StreamInterface;
/**
 * Adapts a Guzzle 5 Stream to a PSR-7 Stream.
 *
 * @codeCoverageIgnore
 */
class PsrStream implements \BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface
{
    use StreamDecoratorTrait;
    /** @var GuzzleStreamInterface */
    private $stream;
    public function __construct(\BaghelSoft\S3Uploads\GuzzleHttp\Stream\StreamInterface $stream)
    {
        $this->stream = $stream;
    }
    public function rewind()
    {
        $this->stream->seek(0);
    }
    public function getContents()
    {
        return $this->stream->getContents();
    }
}
