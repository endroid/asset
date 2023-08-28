<?php

declare(strict_types=1);

namespace Endroid\Asset;

final class DataAsset extends AbstractAsset
{
    public function __construct(
        private readonly string $data
    ) {
    }

    public function getData(): string
    {
        return $this->data;
    }
}
