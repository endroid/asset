<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Asset;

use Endroid\Asset\TemplateAsset;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

final class TemplateAssetTest extends TestCase
{
    #[TestDox('Get data from template asset')]
    public function testGetData(): void
    {
        $twig = $this->createMock(Environment::class);
        $twig->method('render')
            ->with('template.html.twig', ['key' => 'value'])
            ->willReturn('rendered content');

        $asset = new TemplateAsset($twig, 'template.html.twig', ['key' => 'value']);

        static::assertSame('rendered content', $asset->getData());
    }
}
