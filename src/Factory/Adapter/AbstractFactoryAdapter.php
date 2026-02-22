<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\Exception\UndefinedAssetClassException;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract readonly class AbstractFactoryAdapter implements FactoryAdapterInterface
{
    public function __construct(
        public int $guesserPriority = 1,
    ) {}

    #[\Override]
    public function getGuesserPriority(): int
    {
        return $this->guesserPriority;
    }

    /** @param array<mixed> $options */
    #[\Override]
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

    #[\Override]
    public function getAssetClassName(): string
    {
        $assetClassName = (string) preg_replace('#Factory.?Adapter.?#i', replacement: '', subject: get_class($this));

        if (!class_exists($assetClassName)) {
            throw new UndefinedAssetClassException(sprintf(
                'Asset class for asset factory "%s" could not be determined automatically. Please implement getAssetClassName() or override protected property $assetClassName.',
                get_class($this),
            ));
        }

        return $assetClassName;
    }
}
