<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface FactoryAdapterInterface
{
    public function getAssetClassName(): string;

    public function setGuesserPriority(int $guesserPriority): void;

    public function getGuesserPriority(): int;

    public function isValidGuess(array $options): bool;

    public function configureOptions(OptionsResolver $resolver): void;

    public function create(array $options): AssetInterface;
}
