<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\CallbackAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final readonly class CallbackAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['callback']);
    }

    /** @param array<string> $options */
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        return new CallbackAsset($options['callback']);
    }
}
