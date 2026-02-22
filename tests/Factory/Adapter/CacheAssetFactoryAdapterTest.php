<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory\Adapter;

use Endroid\Asset\CacheAsset;
use Endroid\Asset\DataAsset;
use Endroid\Asset\Factory\Adapter\CacheAssetFactoryAdapter;
use Endroid\Asset\Factory\Adapter\DataAssetFactoryAdapter;
use Endroid\Asset\Factory\AssetFactory;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;

final class CacheAssetFactoryAdapterTest extends TestCase
{
    #[TestDox('Create cache asset via adapter')]
    public function testCreate(): void
    {
        $cache = $this->createMock(CacheItemPoolInterface::class);
        $assetFactory = new AssetFactory();
        $assetFactory->addFactory(new DataAssetFactoryAdapter());

        $adapter = new CacheAssetFactoryAdapter($cache, $assetFactory);
        $asset = $adapter->create([
            'cache_key' => 'my_key',
            'asset_class' => DataAsset::class,
            'data' => 'test',
        ]);

        static::assertInstanceOf(CacheAsset::class, $asset);
    }

    #[TestDox('Create cache asset with tags and expiration')]
    public function testCreateWithTagsAndExpiration(): void
    {
        $cache = $this->createMock(CacheItemPoolInterface::class);
        $assetFactory = new AssetFactory();
        $assetFactory->addFactory(new DataAssetFactoryAdapter());

        $adapter = new CacheAssetFactoryAdapter($cache, $assetFactory);
        $asset = $adapter->create([
            'cache_key' => 'my_key',
            'asset_class' => DataAsset::class,
            'data' => 'test',
            'cache_tags' => ['tag1'],
            'cache_expires_after' => 3600,
            'cache_clear' => true,
        ]);

        static::assertInstanceOf(CacheAsset::class, $asset);
    }

    #[TestDox('Valid guess requires cache_key')]
    public function testIsValidGuess(): void
    {
        $cache = $this->createMock(CacheItemPoolInterface::class);
        $assetFactory = new AssetFactory();

        $adapter = new CacheAssetFactoryAdapter($cache, $assetFactory);

        static::assertTrue($adapter->isValidGuess(['cache_key' => 'key']));
        static::assertFalse($adapter->isValidGuess(['data' => 'test']));
    }

    #[TestDox('Guesser priority is 0')]
    public function testGuesserPriority(): void
    {
        $cache = $this->createMock(CacheItemPoolInterface::class);
        $assetFactory = new AssetFactory();

        $adapter = new CacheAssetFactoryAdapter($cache, $assetFactory);

        static::assertSame(0, $adapter->getGuesserPriority());
    }
}
