<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\DataAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DataAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        $asset = new DataAsset($options['data']);

        return $asset;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['data']);
    }
}
