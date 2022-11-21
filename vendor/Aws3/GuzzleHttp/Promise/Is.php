<?php

namespace BaghelSoft\S3Uploads\GuzzleHttp\Promise;

final class Is
{
    /**
     * Returns true if a promise is pending.
     *
     * @return bool
     */
    public static function pending(\BaghelSoft\S3Uploads\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \BaghelSoft\S3Uploads\GuzzleHttp\Promise\PromiseInterface::PENDING;
    }
    /**
     * Returns true if a promise is fulfilled or rejected.
     *
     * @return bool
     */
    public static function settled(\BaghelSoft\S3Uploads\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() !== \BaghelSoft\S3Uploads\GuzzleHttp\Promise\PromiseInterface::PENDING;
    }
    /**
     * Returns true if a promise is fulfilled.
     *
     * @return bool
     */
    public static function fulfilled(\BaghelSoft\S3Uploads\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \BaghelSoft\S3Uploads\GuzzleHttp\Promise\PromiseInterface::FULFILLED;
    }
    /**
     * Returns true if a promise is rejected.
     *
     * @return bool
     */
    public static function rejected(\BaghelSoft\S3Uploads\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \BaghelSoft\S3Uploads\GuzzleHttp\Promise\PromiseInterface::REJECTED;
    }
}
