<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\Exception\UndefinedAssetClassException;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFactoryAdapter implements FactoryAdapterInterface
{
    public function __construct(
        public readonly int $guesserPriority = 1
    ) {
    }

    public function getGuesserPriority(): int
    {
        return $this->guesserPriority;
    }

    /** @param array<string> $options */
    public function isValidGuess(array $options): bool
    {
        try {
            $this->getOptionsResolver()->resolve($options);
        } catch (\Exception) {
            return false;
        }

        return true;
    }

    public function getOptionsResolver(): OptionsResolver
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);

        return $optionsResolver;
    }

    public function getAssetClassName(): string
    {
        $assetClassName = (string) preg_replace('#Factory.?Adapter.?#i', '', get_class($this));

        if (!class_exists($assetClassName)) {
            throw new UndefinedAssetClassException(sprintf('Asset class for asset factory "%s" could not be determined automatically. Please implement getAssetClassName() or override protected property $assetClassName.', get_class($this)));
        }

        return $assetClassName;
    }
}
