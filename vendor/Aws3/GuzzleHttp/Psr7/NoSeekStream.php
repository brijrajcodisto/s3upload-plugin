<?php

namespace BaghelSoft\S3Uploads\GuzzleHttp\Psr7;

use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream implements \BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface
{
    use StreamDecoratorTrait;
    public function seek($offset, $whence = SEEK_SET)
    {
        throw new \RuntimeException('Cannot seek a NoSeekStream');
    }
    public function isSeekable()
    {
        return false;
    }
}
