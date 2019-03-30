<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

final class UrlAsset extends AbstractAsset
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getData(): string
    {
        return (string) file_get_contents($this->url);
    }
}
