<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory\Adapter;

use Endroid\Asset\Factory\Adapter\UrlAssetFactoryAdapter;
use Endroid\Asset\UrlAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class UrlAssetFactoryAdapterTest extends TestCase
{
    #[TestDox('Create url asset via adapter')]
    public function testCreate(): void
    {
        $adapter = new UrlAssetFactoryAdapter();
        $asset = $adapter->create(['url' => 'https://example.com']);

        static::assertInstanceOf(UrlAsset::class, $asset);
    }
}
