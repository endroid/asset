<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\MultiUrlAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MultiUrlAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['urls']);
    }

    /** @param array<string> $options */
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        return new MultiUrlAsset($options['urls']);
    }
}
