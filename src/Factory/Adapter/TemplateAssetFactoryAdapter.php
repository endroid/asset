<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\TemplateAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

final class TemplateAssetFactoryAdapter extends AbstractFactoryAdapter
{
    private $renderer;

    public function __construct(Environment $renderer)
    {
        $this->renderer = $renderer;
    }

    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        $asset = new TemplateAsset($this->renderer, $options['template'], $options['parameters']);

        return $asset;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults(['parameters' => []])
            ->setRequired(['template'])
        ;
    }
}