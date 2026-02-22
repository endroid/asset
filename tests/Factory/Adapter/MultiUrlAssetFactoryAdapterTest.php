<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory\Adapter;

use Endroid\Asset\Factory\Adapter\MultiUrlAssetFactoryAdapter;
use Endroid\Asset\MultiUrlAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class MultiUrlAssetFactoryAdapterTest extends TestCase
{
    #[TestDox('Create multi url asset via adapter')]
    public function testCreate(): void
    {
        $adapter = new MultiUrlAssetFactoryAdapter();
        $asset = $adapter->create(['urls' => ['https://a.com', 'https://b.com']]);

        static::assertInstanceOf(MultiUrlAsset::class, $asset);
    }
}
