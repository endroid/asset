<?php

declare(strict_types=1);

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
    /** @var ClassGuesser */
    private $classGuesser;

    /** @var array<string, FactoryAdapterInterface> */
    private $factories;

    public function __construct(ClassGuesser $classGuesser = null)
    {
        $this->classGuesser = $classGuesser instanceof ClassGuesser ? $classGuesser : new ClassGuesser();
        $this->factories = [];
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

        $asset = $this->factories[$className]->create($options);

        return $asset;
    }
}
