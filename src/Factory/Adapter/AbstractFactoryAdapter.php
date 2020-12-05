<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\Exception\UndefinedAssetClassException;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFactoryAdapter implements FactoryAdapterInterface
{
    /** @var int */
    private $guesserPriority;

    public function __construct(int $guesserPriority = 1)
    {
        $this->guesserPriority = $guesserPriority;
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
        } catch (\Exception $exception) {
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
