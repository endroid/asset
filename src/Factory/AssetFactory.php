<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\Exception\UnsupportedAssetClassException;
use Endroid\Asset\Factory\Adapter\FactoryAdapterInterface;
use Endroid\Asset\Guesser\ClassGuesser;

final class AssetFactory
{
    public function __construct(
        private readonly ClassGuesser $classGuesser = new ClassGuesser(),
        /** @var array<string, FactoryAdapterInterface> */
        private array $factories = []
    ) {
    }

    /** @param iterable<FactoryAdapterInterface> $factories */
    public function addFactories(iterable $factories): void
    {
        foreach ($factories as $factory) {
            $this->addFactory($factory);
        }
    }

    public function addFactory(FactoryAdapterInterface $factory): void
    {
        $this->factories[$factory->getAssetClassName()] = $factory;
        $this->classGuesser->addFactory($factory);
    }

    /** @param array<mixed> $options */
    public function create(string $className = null, array $options = []): AssetInterface
    {
        if (null === $className) {
            $className = $this->classGuesser->guessClassName($options);
        }

        if (!isset($this->factories[$className])) {
            throw new UnsupportedAssetClassException(sprintf('Asset class "%s" is not supported', $className));
        }

        return $this->factories[$className]->create($options);
    }
}
