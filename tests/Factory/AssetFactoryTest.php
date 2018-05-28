<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Tests\Factory;

use Endroid\Asset\DataAsset;
use Endroid\Asset\Factory\Adapter\DataAssetFactoryAdapter;
use Endroid\Asset\Factory\AssetFactory;
use Endroid\Asset\Guesser\ClassGuesser;
use PHPUnit\Framework\TestCase;

class AssetFactoryTest extends TestCase
{
    public function testFactory(): void
    {
        $assetFactory = new AssetFactory(new ClassGuesser());
        $assetFactory->addFactory(new DataAssetFactoryAdapter());

        $asset = $assetFactory->create(null, [
            'data' => 'Asset data'
        ]);

        $this->assertInstanceOf(DataAsset::class, $asset);
        $this->assertEquals($asset->getData(), 'Asset data');
    }
}
