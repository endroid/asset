<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\ControllerAsset;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ControllerAssetFactoryAdapter extends AbstractFactoryAdapter
{
    private HttpKernelInterface $kernel;
    private RequestStack $requestStack;

    public function __construct(HttpKernelInterface $kernel, RequestStack $requestStack)
    {
        parent::__construct(1);

        $this->kernel = $kernel;
        $this->requestStack = $requestStack;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults(['parameters' => []])
            ->setRequired(['controller'])
        ;
    }

    /** @param array<string> $options */
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        return new ControllerAsset($this->kernel, $this->requestStack, $options['controller'], $options['parameters']);
    }
}
