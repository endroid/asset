<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\TemplateAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

final class TemplateAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function __construct(
        private Environment $renderer
    ) {
        parent::__construct(1);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults(['parameters' => []])
            ->setRequired(['template'])
        ;
    }

    /** @param array<string> $options */
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        return new TemplateAsset($this->renderer, $options['template'], $options['parameters']);
    }
}
