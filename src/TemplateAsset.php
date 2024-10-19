<?php

declare(strict_types=1);

namespace Endroid\Asset;

use Twig\Environment;

final readonly class TemplateAsset extends AbstractAsset
{
    public function __construct(
        private Environment $templating,
        private string $template,
        /** @var array<mixed> */
        private array $parameters = []
    ) {
    }

    public function getData(): string
    {
        return $this->templating->render($this->template, $this->parameters);
    }
}
