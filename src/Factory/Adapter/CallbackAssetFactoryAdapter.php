<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\CallbackAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CallbackAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['callback']);
    }

    /** @param array<string> $options */
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        return new CallbackAsset($options['callback']);
    }
}
