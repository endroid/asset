<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\FileAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final readonly class FileAssetFactoryAdapter extends AbstractFactoryAdapter
{
    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['path']);
    }

    /** @param array<mixed> $options */
    #[\Override]
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        return new FileAsset((string) ($options['path'] ?? ''));
    }
}
