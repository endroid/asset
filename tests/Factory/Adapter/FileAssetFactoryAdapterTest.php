<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory\Adapter;

use Endroid\Asset\Factory\Adapter\FileAssetFactoryAdapter;
use Endroid\Asset\FileAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class FileAssetFactoryAdapterTest extends TestCase
{
    #[TestDox('Create file asset via adapter')]
    public function testCreate(): void
    {
        $adapter = new FileAssetFactoryAdapter();
        $asset = $adapter->create(['path' => '/tmp/test.txt']);

        static::assertInstanceOf(FileAsset::class, $asset);
    }

    #[TestDox('Valid guess with path option')]
    public function testIsValidGuess(): void
    {
        $adapter = new FileAssetFactoryAdapter();

        static::assertTrue($adapter->isValidGuess(['path' => '/tmp/test.txt']));
        static::assertFalse($adapter->isValidGuess(['url' => 'https://example.com']));
    }

    #[TestDox('Get asset class name')]
    public function testGetAssetClassName(): void
    {
        $adapter = new FileAssetFactoryAdapter();

        static::assertSame('Endroid\Asset\FileAsset', $adapter->getAssetClassName());
    }
}
