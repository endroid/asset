<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

use Symfony\Component\Cache\Adapter\AdapterInterface;

final class CacheAsset extends AbstractAsset
{
    private $asset;
    private $cache;
    private $key;
    private $tags;
    private $expiresAfter;

    public function __construct(AssetInterface $asset, AdapterInterface $cache, string $key, array $tags = [], int $expiresAfter = null)
    {
        $this->asset = $asset;
        $this->cache = $cache;
        $this->key = $key;
        $this->tags = $tags;
        $this->expiresAfter = $expiresAfter;
    }

    public function getData(): string
    {
        $cacheItem = $this->cache->getItem($this->key);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $data = $this->asset->getData();

        $cacheItem->set($data);
        $cacheItem->tag($this->tags);
        $cacheItem->expiresAfter($this->expiresAfter);
        $this->cache->save($cacheItem);

        return $data;
    }
}
