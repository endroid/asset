<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\ControllerAsset;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final readonly class ControllerAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function __construct(
        private HttpKernelInterface $kernel,
        private RequestStack $requestStack,
    ) {
        parent::__construct(1);
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
