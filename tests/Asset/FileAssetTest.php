<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Asset;

use Endroid\Asset\FileAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class FileAssetTest extends TestCase
{
    #[TestDox('Get data from file asset')]
    public function testGetData(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'asset_test_');
        file_put_contents($path, 'file content');

        $asset = new FileAsset($path);

        static::assertSame('file content', $asset->getData());

        unlink($path);
    }
}
