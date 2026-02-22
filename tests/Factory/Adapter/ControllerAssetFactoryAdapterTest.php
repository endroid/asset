<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Factory\Adapter;

use Endroid\Asset\ControllerAsset;
use Endroid\Asset\Factory\Adapter\ControllerAssetFactoryAdapter;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class ControllerAssetFactoryAdapterTest extends TestCase
{
    #[TestDox('Create controller asset via adapter')]
    public function testCreate(): void
    {
        $kernel = $this->createMock(HttpKernelInterface::class);
        $requestStack = new RequestStack();
        $adapter = new ControllerAssetFactoryAdapter($kernel, $requestStack);
        $asset = $adapter->create(['controller' => 'App\\Controller::action', 'parameters' => []]);

        static::assertInstanceOf(ControllerAsset::class, $asset);
    }
}
