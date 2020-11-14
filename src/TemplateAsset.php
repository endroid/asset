<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

use Twig\Environment;

final class TemplateAsset extends AbstractAsset
{
    private Environment $templating;
    private string $template;

    /** @var array<string> */
    private array $parameters;

    /** @param array<string> $parameters */
    public function __construct(Environment $templating, string $template, array $parameters = [])
    {
        $this->templating = $templating;
        $this->template = $template;
        $this->parameters = $parameters;
    }

    public function getData(): string
    {
        return $this->templating->render($this->template, $this->parameters);
    }
}
