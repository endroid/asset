<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Asset;

use Endroid\Asset\DataAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class DataAssetTest extends TestCase
{
    #[TestDox('Get data from data asset')]
    public function testGetData(): void
    {
        $asset = new DataAsset('test data');

        static::assertSame('test data', $asset->getData());
    }

    #[TestDox('Convert data asset to string')]
    public function testToString(): void
    {
        $asset = new DataAsset('string data');

        static::assertSame('string data', (string) $asset);
    }
}
