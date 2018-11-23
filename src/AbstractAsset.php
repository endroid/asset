<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

abstract class AbstractAsset implements AssetInterface
{
    abstract public function getData(): string;

    public function __toString(): string
    {
        return $this->getData();
    }
}
