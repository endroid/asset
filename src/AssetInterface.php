<?php

declare(strict_types=1);

namespace Endroid\Asset;

interface AssetInterface extends \Stringable
{
    public function getData(): string;
}
