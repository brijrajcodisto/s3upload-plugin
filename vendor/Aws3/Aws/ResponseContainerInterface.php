<?php

namespace BaghelSoft\S3Uploads\Aws;

use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
interface ResponseContainerInterface
{
    /**
     * Get the received HTTP response if any.
     *
     * @return ResponseInterface|null
     */
    public function getResponse();
}
