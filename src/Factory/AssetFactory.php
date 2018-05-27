<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Factory;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\Exception\UnsupportedAssetClassException;
use Endroid\Asset\Factory\Adapter\FactoryAdapterInterface;
use Endroid\Asset\Guesser\ClassGuesser;

class AssetFactory
{
    private $classGuesser;
    private $factories;

    public function __construct(ClassGuesser $classGuesser)
    {
        $this->classGuesser = $classGuesser;
        $this->factories = [];
    }

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

    public function create(string $className = null, array $options = []): AssetInterface
    {
        if (null === $className) {
            $className = $this->classGuesser->guessClassName($options);
        }

        if (!isset($this->factories[$className])) {
            throw new UnsupportedAssetClassException(sprintf('Asset class "%s" is not supported', $className));
        }

        $asset = $this->factories[$className]->create($options);

        return $asset;
    }
}
