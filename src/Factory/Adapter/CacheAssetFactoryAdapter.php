<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\CacheAsset;
use Endroid\Asset\Factory\AssetFactory;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final readonly class CacheAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function __construct(
        private CacheItemPoolInterface $cache,
        private AssetFactory $assetFactory,
    ) {
        parent::__construct(0);
    }

    /** @param array<mixed> $options */
    #[\Override]
    public function isValidGuess(array $options): bool
    {
        return array_key_exists('cache_key', $options);
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'asset_class' => null,
            'cache_tags' => [],
            'cache_expires_after' => 0,
            'cache_clear' => false,
        ])->setRequired(['cache_key']);
    }

    /** @param array<mixed> $options */
    #[\Override]
    public function create(array $options = []): AssetInterface
    {
        $cacheOptions = $this->getOptionsResolver()->getDefinedOptions();

        $optionsResolver = clone $this->getOptionsResolver();
        $optionsResolver->setDefined(array_map(strval(...), array_keys($options)));
        $options = $optionsResolver->resolve($options);

        $assetClassName = (string) ($options['asset_class'] ?? '');
        $assetOptions = array_diff_key($options, array_flip($cacheOptions));

        $cachedAsset = $this->assetFactory->create($assetClassName, $assetOptions);

        /** @var array<string> $cacheTags */
        $cacheTags = $options['cache_tags'] ?? [];

        /** @var bool $cacheClear */
        $cacheClear = $options['cache_clear'] ?? false;

        return new CacheAsset(
            $cachedAsset,
            $this->cache,
            (string) ($options['cache_key'] ?? ''),
            $cacheTags,
            (int) ($options['cache_expires_after'] ?? 0),
            $cacheClear,
        );
    }
}
