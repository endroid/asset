<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory;

use Endroid\Asset\Exception\UnsupportedAssetClassException;
use Endroid\Asset\Factory\Adapter\CallbackAssetFactoryAdapter;
use Endroid\Asset\Factory\Adapter\DataAssetFactoryAdapter;
use Endroid\Asset\Factory\Adapter\FileAssetFactoryAdapter;
use Endroid\Asset\Factory\AssetFactory;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class AssetFactoryExtendedTest extends TestCase
{
    #[TestDox('Add multiple factories at once')]
    public function testAddFactories(): void
    {
        $factory = new AssetFactory();
        $factory->addFactories([
            new DataAssetFactoryAdapter(),
            new FileAssetFactoryAdapter(),
        ]);

        $asset = $factory->create(null, ['data' => 'test']);
        static::assertSame('test', $asset->getData());
    }

    #[TestDox('Throw exception for unsupported asset class')]
    public function testUnsupportedAssetClass(): void
    {
        $factory = new AssetFactory();

        $this->expectException(UnsupportedAssetClassException::class);
        $factory->create('NonExistent\\Class');
    }
}
