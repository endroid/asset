<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\UrlAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final readonly class UrlAssetFactoryAdapter extends AbstractFactoryAdapter
{
    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['url']);
    }

    /** @param array<mixed> $options */
    #[\Override]
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        return new UrlAsset((string) ($options['url'] ?? ''));
    }
}
