<?php

declare(strict_types=1);

namespace Endroid\Asset;

use Twig\Environment;

final class TemplateAsset extends AbstractAsset
{
    public function __construct(
        private readonly Environment $templating,
        private readonly string $template,
        /** @var array<mixed> */
        private readonly array $parameters = []
    ) {
    }

    public function getData(): string
    {
        return $this->templating->render($this->template, $this->parameters);
    }
}
