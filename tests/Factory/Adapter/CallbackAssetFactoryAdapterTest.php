<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory\Adapter;

use Endroid\Asset\CallbackAsset;
use Endroid\Asset\Factory\Adapter\CallbackAssetFactoryAdapter;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class CallbackAssetFactoryAdapterTest extends TestCase
{
    #[TestDox('Create callback asset via adapter')]
    public function testCreate(): void
    {
        $adapter = new CallbackAssetFactoryAdapter();
        $asset = $adapter->create(['callback' => static fn(): string => 'result']);

        static::assertInstanceOf(CallbackAsset::class, $asset);
    }
}
