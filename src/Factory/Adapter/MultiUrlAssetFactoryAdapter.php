<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\MultiUrlAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final readonly class MultiUrlAssetFactoryAdapter extends AbstractFactoryAdapter
{
    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['urls']);
    }

    /** @param array<mixed> $options */
    #[\Override]
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        /** @var array<non-empty-string> $urls */
        $urls = $options['urls'] ?? [];

        return new MultiUrlAsset($urls);
    }
}
