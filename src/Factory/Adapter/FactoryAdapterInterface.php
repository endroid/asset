<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface FactoryAdapterInterface
{
    public function getAssetClassName(): string;

    public function getGuesserPriority(): int;

    /** @param array<string> $options */
    public function isValidGuess(array $options): bool;

    public function configureOptions(OptionsResolver $resolver): void;

    /** @param array<string> $options */
    public function create(array $options): AssetInterface;
}
