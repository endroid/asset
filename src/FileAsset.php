<?php

declare(strict_types=1);

namespace Endroid\Asset;

final class FileAsset extends AbstractAsset
{
    public function __construct(
        private string $path
    ) {
    }

    public function getData(): string
    {
        return (string) file_get_contents($this->path);
    }
}
