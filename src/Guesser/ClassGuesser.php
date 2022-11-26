<?php

declare(strict_types=1);

namespace Endroid\Asset\Guesser;

use Endroid\Asset\Exception\UndefinedAssetClassException;
use Endroid\Asset\Factory\Adapter\FactoryAdapterInterface;

final class ClassGuesser
{
    /** @var array<string, FactoryAdapterInterface> */
    private array $factories = [];

    public function addFactory(FactoryAdapterInterface $factory): void
    {
        $this->factories[$factory->getAssetClassName()] = $factory;

        uasort($this->factories, function (FactoryAdapterInterface $factory1, FactoryAdapterInterface $factory2) {
            return $factory1->getGuesserPriority() - $factory2->getGuesserPriority();
        });
    }

    /** @param array<string> $options */
    public function guessClassName(array $options = []): string
    {
        foreach ($this->factories as $assetClassName => $factory) {
            if ($factory->isValidGuess($options)) {
                return $assetClassName;
            }
        }

        throw new UndefinedAssetClassException('Asset class could not be guessed');
    }
}
