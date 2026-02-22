<?php

declare(strict_types=1);

namespace Endroid\Asset\Factory\Adapter;

use Endroid\Asset\AssetInterface;
use Endroid\Asset\TemplateAsset;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

final readonly class TemplateAssetFactoryAdapter extends AbstractFactoryAdapter
{
    public function __construct(
        private Environment $renderer,
    ) {
        parent::__construct(1);
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['parameters' => []])->setRequired(['template']);
    }

    /** @param array<mixed> $options */
    #[\Override]
    public function create(array $options = []): AssetInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        /** @var array<mixed> $parameters */
        $parameters = $options['parameters'] ?? [];

        return new TemplateAsset($this->renderer, (string) ($options['template'] ?? ''), $parameters);
    }
}
