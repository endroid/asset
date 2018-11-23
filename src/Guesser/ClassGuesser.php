<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Guesser;

use Endroid\Asset\Exception\UndefinedAssetClassException;
use Endroid\Asset\Factory\Adapter\FactoryAdapterInterface;

final class ClassGuesser
{
    private $factories;
    private $factoriesAreSorted;

    public function __construct()
    {
        $this->factories = [];
        $this->factoriesAreSorted = false;
    }

    public function addFactory(FactoryAdapterInterface $factory): void
    {
        $this->factories[] = $factory;
        $this->factoriesAreSorted = false;
    }

    public function guessClassName(array $options = []): string
    {
        if (!$this->factoriesAreSorted) {
            usort($this->factories, function (FactoryAdapterInterface $factory1, FactoryAdapterInterface $factory2) {
                return $factory1->getGuesserPriority() - $factory2->getGuesserPriority();
            });
            $this->factoriesAreSorted = true;
        }

        foreach ($this->factories as $factory) {
            if ($factory->isValidGuess($options)) {
                return $factory->getAssetClassName();
            }
        }

        throw new UndefinedAssetClassException('Asset class could not be guessed');
    }
}
