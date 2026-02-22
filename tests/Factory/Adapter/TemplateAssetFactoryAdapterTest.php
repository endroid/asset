<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory\Adapter;

use Endroid\Asset\Factory\Adapter\TemplateAssetFactoryAdapter;
use Endroid\Asset\TemplateAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

final class TemplateAssetFactoryAdapterTest extends TestCase
{
    #[TestDox('Create template asset via adapter')]
    public function testCreate(): void
    {
        $twig = $this->createMock(Environment::class);
        $adapter = new TemplateAssetFactoryAdapter($twig);
        $asset = $adapter->create(['template' => 'test.html.twig', 'parameters' => ['key' => 'value']]);

        static::assertInstanceOf(TemplateAsset::class, $asset);
    }
}
