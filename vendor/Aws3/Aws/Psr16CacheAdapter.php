<?php

namespace BaghelSoft\S3Uploads\Aws;

use BaghelSoft\S3Uploads\Psr\SimpleCache\CacheInterface as SimpleCacheInterface;
class Psr16CacheAdapter implements \BaghelSoft\S3Uploads\Aws\CacheInterface
{
    /** @var SimpleCacheInterface */
    private $cache;
    public function __construct(\BaghelSoft\S3Uploads\Psr\SimpleCache\CacheInterface $cache)
    {
        $this->cache = $cache;
    }
    public function get($key)
    {
        return $this->cache->get($key);
    }
    public function set($key, $value, $ttl = 0)
    {
        $this->cache->set($key, $value, $ttl);
    }
    public function remove($key)
    {
        $this->cache->delete($key);
    }
}
