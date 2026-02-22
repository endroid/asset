<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Asset;

use Endroid\Asset\CacheAsset;
use Endroid\Asset\DataAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class CacheAssetTest extends TestCase
{
    #[TestDox('Get data on cache miss')]
    public function testCacheMiss(): void
    {
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->method('isHit')->willReturn(false);
        $cacheItem->expects(static::once())->method('set')->with('test data');

        $cache = $this->createMock(CacheItemPoolInterface::class);
        $cache->method('getItem')->with('test_key')->willReturn($cacheItem);
        $cache->expects(static::once())->method('save')->with($cacheItem);

        $asset = new CacheAsset(new DataAsset('test data'), $cache, 'test_key');

        static::assertSame('test data', $asset->getData());
    }

    #[TestDox('Get data on cache hit')]
    public function testCacheHit(): void
    {
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->method('isHit')->willReturn(true);
        $cacheItem->method('get')->willReturn('cached data');

        $cache = $this->createMock(CacheItemPoolInterface::class);
        $cache->method('getItem')->with('test_key')->willReturn($cacheItem);

        $asset = new CacheAsset(new DataAsset('test data'), $cache, 'test_key');

        static::assertSame('cached data', $asset->getData());
    }

    #[TestDox('Clear cache before fetching')]
    public function testCacheClear(): void
    {
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->method('isHit')->willReturn(false);

        $cache = $this->createMock(CacheItemPoolInterface::class);
        $cache->expects(static::once())->method('deleteItem')->with('test_key');
        $cache->method('getItem')->with('test_key')->willReturn($cacheItem);
        $cache->method('save');

        $asset = new CacheAsset(new DataAsset('data'), $cache, 'test_key', clear: true);

        $asset->getData();
    }

    #[TestDox('Set tags on cache item')]
    public function testCacheTags(): void
    {
        $cacheItem = $this->createMock(ItemInterface::class);
        $cacheItem->method('isHit')->willReturn(false);
        $cacheItem->expects(static::once())->method('tag')->with(['tag1', 'tag2']);

        $cache = $this->createMock(CacheItemPoolInterface::class);
        $cache->method('getItem')->with('test_key')->willReturn($cacheItem);
        $cache->method('save');

        $asset = new CacheAsset(new DataAsset('data'), $cache, 'test_key', tags: ['tag1', 'tag2']);

        $asset->getData();
    }

    #[TestDox('Set expiration on cache item')]
    public function testCacheExpiration(): void
    {
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->method('isHit')->willReturn(false);
        $cacheItem->expects(static::once())->method('expiresAfter')->with(3600);

        $cache = $this->createMock(CacheItemPoolInterface::class);
        $cache->method('getItem')->with('test_key')->willReturn($cacheItem);
        $cache->method('save');

        $asset = new CacheAsset(new DataAsset('data'), $cache, 'test_key', expiresAfter: 3600);

        $asset->getData();
    }
}
