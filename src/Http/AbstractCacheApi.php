<?php

declare(strict_types=1);

namespace App\Http;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;

abstract class AbstractCacheApi
{
    protected RedisAdapter $cache;

    public function __construct()
    {
        $this->cache = new RedisAdapter(RedisAdapter::createConnection($_SERVER['REDIS_URL']));
    }

    final protected function getFromCache(CacheItemInterface $cacheItem): mixed
    {
        return $cacheItem->get() ?? null;
    }

    final protected function getCacheItem(string $key): CacheItemInterface
    {
        return $this->cache->getItem($key);
    }

    final protected function isCached(CacheItemInterface $cacheItem): bool
    {
        return (bool)$this->getFromCache($cacheItem);
    }
}
