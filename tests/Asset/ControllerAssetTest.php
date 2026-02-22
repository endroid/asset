<?php

declare(strict_types=1);

namespace Endroid\Asset\Tests\Asset;

use Endroid\Asset\ControllerAsset;
use Endroid\Asset\Exception\InvalidRequestException;
use Endroid\Asset\Exception\InvalidResponseException;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class ControllerAssetTest extends TestCase
{
    #[TestDox('Get data from controller asset')]
    public function testGetData(): void
    {
        $request = Request::create('/test');
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $response = new Response('controller output');

        $kernel = $this->createMock(HttpKernelInterface::class);
        $kernel->method('handle')
            ->willReturn($response);

        $asset = new ControllerAsset($kernel, $requestStack, 'App\\Controller::action', ['param' => 'value']);

        static::assertSame('controller output', $asset->getData());
    }

    #[TestDox('Throw exception when no current request')]
    public function testNoCurrentRequest(): void
    {
        $requestStack = new RequestStack();
        $kernel = $this->createMock(HttpKernelInterface::class);

        $asset = new ControllerAsset($kernel, $requestStack, 'App\\Controller::action');

        $this->expectException(InvalidRequestException::class);
        $asset->getData();
    }

    #[TestDox('Throw exception when response content is not a string')]
    public function testInvalidResponse(): void
    {
        $request = Request::create('/test');
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $response = $this->createMock(Response::class);
        $response->method('getContent')
            ->willReturn(false);

        $kernel = $this->createMock(HttpKernelInterface::class);
        $kernel->method('handle')
            ->willReturn($response);

        $asset = new ControllerAsset($kernel, $requestStack, 'App\\Controller::action');

        $this->expectException(InvalidResponseException::class);
        $asset->getData();
    }
}
