<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\DataAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final readonly class DataAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['data']);
    }

    /** @param array<string> $options */
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        return new DataAsset($options['data']);
    }
}
