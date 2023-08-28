<?php

declare(strict_types=1);

namespace Endroid\Asset;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class CacheAsset extends AbstractAsset
{
    public function __construct(
        private readonly AssetInterface $asset,
        private readonly CacheItemPoolInterface $cache,
        private readonly string $key,
        /** @var array<string> */
        private readonly array $tags = [],
        private readonly int $expiresAfter = 0,
        private readonly bool $clear = false
    ) {
    }

    public function getData(): string
    {
        if ($this->clear) {
            $this->cache->deleteItem($this->key);
        }

        $cacheItem = $this->cache->getItem($this->key);

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->asset->getData();

        $cacheItem->set($data);

        if (count($this->tags) > 0 && $cacheItem instanceof ItemInterface) {
            $cacheItem->tag($this->tags);
        }

        if ($this->expiresAfter > 0) {
            $cacheItem->expiresAfter($this->expiresAfter);
        }

        $this->cache->save($cacheItem);

        return $data;
    }
}
