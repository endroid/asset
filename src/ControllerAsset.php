<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

use Endroid\Asset\Exception\InvalidRequestException;
use Endroid\Asset\Exception\InvalidResponseException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class ControllerAsset extends AbstractAsset
{
    private $kernel;
    private $requestStack;
    private $controller;
    private $controllerParameters;

    public function __construct(
        HttpKernelInterface $kernel,
        RequestStack $requestStack,
        string $controller,
        array $controllerParameters = []
    ) {
        $this->kernel = $kernel;
        $this->requestStack = $requestStack;
        $this->controller = $controller;
        $this->controllerParameters = $controllerParameters;
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
        $data = $response->getContent();

        if (!is_string($data)) {
            throw new InvalidResponseException('Invalid response from controller');
        }

        return $data;
    }
}
