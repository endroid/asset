<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class CacheAsset extends AbstractAsset
{
    /** @var AssetInterface */
    private $asset;

    /** @var CacheItemPoolInterface */
    private $cache;

    /** @var string */
    private $key;

    /** @var array<string> */
    private $tags;

    /** @var int */
    private $expiresAfter;

    /** @var bool */
    private $clear;

    /** @param array<string> $tags */
    public function __construct(
        AssetInterface $asset,
        CacheItemPoolInterface $cache,
        string $key,
        array $tags = [],
        int $expiresAfter = 0,
        bool $clear = false
    ) {
        $this->asset = $asset;
        $this->cache = $cache;
        $this->key = $key;
        $this->tags = $tags;
        $this->expiresAfter = $expiresAfter;
        $this->clear = $clear;
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
