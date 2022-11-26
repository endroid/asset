<?php

declare(strict_types=1);

namespace Endroid\Asset;

use Endroid\Asset\Exception\InvalidRequestException;
use Endroid\Asset\Exception\InvalidResponseException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class ControllerAsset extends AbstractAsset
{
    public function __construct(
        private HttpKernelInterface $kernel,
        private RequestStack $requestStack,
        private string $controller,
        /** @var array<mixed> */
        private array $controllerParameters = []
    ) {
    }

    public function getData(): string
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request instanceof Request) {
            throw new InvalidRequestException('Could not determine current request');
        }

        $this->controllerParameters['_forwarded'] = $request->attributes;
        $this->controllerParameters['_controller'] = $this->controller;
        $subRequest = $request->duplicate([], null, $this->controllerParameters);

        $response = $this->kernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        /** @psalm-suppress ReservedWord */
        $data = $response->getContent();

        if (!is_string($data)) {
            throw new InvalidResponseException('Invalid response from controller');
        }

        return $data;
    }
}
