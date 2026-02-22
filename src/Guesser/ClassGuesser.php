<?php

declare(strict_types=1);

namespace Endroid\Asset\Guesser;

use Endroid\Asset\Exception\UndefinedAssetClassException;
use Endroid\Asset\Factory\Adapter\FactoryAdapterInterface;

final class ClassGuesser
{
    public function __construct(
        /** @var array<string, FactoryAdapterInterface> */
        private array $factories = [],
    ) {}

    public function addFactory(FactoryAdapterInterface $factory): void
    {
        $this->factories[$factory->getAssetClassName()] = $factory;

        uasort(
            $this->factories,
            static fn(
                FactoryAdapterInterface $factory1,
                FactoryAdapterInterface $factory2,
            ) => $factory1->getGuesserPriority() - $factory2->getGuesserPriority(),
        );
    }

    /** @param array<mixed> $options */
    public function guessClassName(array $options = []): string
    {
        return (
            array_find_key(
                $this->factories,
                static fn(FactoryAdapterInterface $factory): bool => $factory->isValidGuess($options),
            ) ?? throw new UndefinedAssetClassException('Asset class could not be guessed')
        );
    }
}
