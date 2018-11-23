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
use Endroid\Asset\FileAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class FileAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        $asset = new FileAsset($options['path']);

        return $asset;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['path']);
    }
}
