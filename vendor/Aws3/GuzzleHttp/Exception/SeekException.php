<?php

namespace BaghelSoft\S3Uploads\GuzzleHttp\Exception;

use BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface;
/**
 * Exception thrown when a seek fails on a stream.
 */
class SeekException extends \RuntimeException implements \BaghelSoft\S3Uploads\GuzzleHttp\Exception\GuzzleException
{
    private $stream;
    public function __construct(\BaghelSoft\S3Uploads\Psr\Http\Message\StreamInterface $stream, $pos = 0, $msg = '')
    {
        $this->stream = $stream;
        $msg = $msg ?: 'Could not seek the stream to position ' . $pos;
        parent::__construct($msg);
    }
    /**
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
