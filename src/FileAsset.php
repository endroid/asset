<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

final class FileAsset extends AbstractAsset
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getData(): string
    {
        return (string) file_get_contents($this->path);
    }
}
