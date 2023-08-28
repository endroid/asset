<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory;

use Endroid\Asset\DataAsset;
use Endroid\Asset\Factory\Adapter\DataAssetFactoryAdapter;
use Endroid\Asset\Factory\AssetFactory;
use PHPUnit\Framework\TestCase;

final class AssetFactoryTest extends TestCase
{
    /**
     * @testdox Create data asset via factory
     */
    public function testFactory(): void
    {
        $assetFactory = new AssetFactory();
        $assetFactory->addFactory(new DataAssetFactoryAdapter());

        $asset = $assetFactory->create(null, [
            'data' => 'Asset data',
        ]);

        $this->assertInstanceOf(DataAsset::class, $asset);
        $this->assertEquals($asset->getData(), 'Asset data');
    }
}
