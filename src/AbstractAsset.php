<?php

declare(strict_types=1);

namespace Endroid\Asset;

abstract class AbstractAsset implements AssetInterface
{
    abstract public function getData(): string;

    public function __toString(): string
    {
        return $this->getData();
    }
}
