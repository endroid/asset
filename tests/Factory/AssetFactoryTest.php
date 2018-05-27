<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Tests\Factory;

use Endroid\Asset\DataAsset;
use Endroid\Asset\Factory\AssetFactory;

class AssetFactoryTest extends TestCase
{
    public function testFactory()
    {
        $assetFactory = new AssetFactory();
        $assetFactory->addFactory(new DataAssetFactory());

        $asset = $assetFactory->create(DataAsset::class, [
            'data' => 'Asset data'
        ]);

        $this->assertInstanceOf(DataAsset::class, $asset);
    }
}
