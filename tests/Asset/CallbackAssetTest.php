<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Asset;

use Endroid\Asset\CallbackAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class CallbackAssetTest extends TestCase
{
    #[TestDox('Get data from callback asset')]
    public function testGetData(): void
    {
        $asset = new CallbackAsset(static fn(): string => 'callback result');

        static::assertSame('callback result', $asset->getData());
    }
}
