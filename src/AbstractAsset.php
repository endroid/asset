<?php

declare(strict_types=1);

namespace Endroid\Asset;

abstract readonly class AbstractAsset implements AssetInterface
{
    #[\Override]
    abstract public function getData(): string;

    #[\Override]
    public function __toString(): string
    {
        return $this->getData();
    }
}
