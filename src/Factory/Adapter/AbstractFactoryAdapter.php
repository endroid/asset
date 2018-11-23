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
    private $optionsResolver;

    protected $assetClassName;
    protected $guesserPriority = 1;

    public function setGuesserPriority(int $guesserPriority): void
    {
        $this->guesserPriority = $guesserPriority;
    }

    public function getGuesserPriority(): int
    {
        return $this->guesserPriority;
    }

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
        if (null === $this->optionsResolver) {
            $this->optionsResolver = new OptionsResolver();
            $this->configureOptions($this->optionsResolver);
        }

        return $this->optionsResolver;
    }

    public function getAssetClassName(): string
    {
        if (null !== $this->assetClassName) {
            return $this->assetClassName;
        }

        $factoryClassName = get_class($this);
        $this->assetClassName = preg_replace('#Factory.?Adapter.?#i', '', $factoryClassName);

        if (!class_exists($this->assetClassName)) {
            throw new UndefinedAssetClassException(sprintf('Asset class for asset factory "%s" could not be determined automatically. Please implement getAssetClassName() or override protected property $assetClassName.', $factoryClassName));
        }

        return $this->assetClassName;
    }
}
