<?php

declare(strict_types=1);

namespace Endroid\Asset;

final readonly class DataAsset extends AbstractAsset
{
    public function __construct(
        private string $data,
    ) {}

    #[\Override]
    public function getData(): string
    {
        return $this->data;
    }
}
