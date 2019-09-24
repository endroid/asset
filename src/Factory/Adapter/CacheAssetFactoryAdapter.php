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
use Endroid\Asset\CacheAsset;
use Endroid\Asset\Factory\AssetFactory;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CacheAssetFactoryAdapter extends AbstractFactoryAdapter
{
    private $cache;
    private $assetFactory;

    public function __construct(CacheItemPoolInterface $cache, AssetFactory $assetFactory)
    {
        parent::__construct(0);

        $this->cache = $cache;
        $this->assetFactory = $assetFactory;
    }

    public function isValidGuess(array $options): bool
    {
        return isset($options['cache_key']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'asset_class' => null,
                'cache_tags' => [],
                'cache_expires_after' => null,
                'cache_clear' => false,
            ])
            ->setRequired(['cache_key'])
        ;
    }

    public function create(array $options = []): AssetInterface
    {
        $cacheOptions = $this->getOptionsResolver()->getDefinedOptions();

        $optionsResolver = clone $this->getOptionsResolver();
        $optionsResolver->setDefined(array_keys($options));
        $options = $optionsResolver->resolve($options);

        $assetClassName = $options['asset_class'];
        $assetOptions = [];
        foreach ($options as $key => $value) {
            if (!in_array($key, $cacheOptions)) {
                $assetOptions[$key] = $value;
            }
        }

        $cachedAsset = $this->assetFactory->create($assetClassName, $assetOptions);
        $asset = new CacheAsset($cachedAsset, $this->cache, $options['cache_key'], $options['cache_tags'], $options['cache_expires_after'], $options['cache_clear']);

        return $asset;
    }
}
