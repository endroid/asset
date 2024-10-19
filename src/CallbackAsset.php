<?php

declare(strict_types=1);

namespace Endroid\Asset;

final readonly class CallbackAsset extends AbstractAsset
{
    public function __construct(
        /** @var callable */
        private mixed $callable,
    ) {
    }

    public function getData(): string
    {
        return call_user_func($this->callable);
    }
}
