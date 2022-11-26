<?php

declare(strict_types=1);

namespace Endroid\Asset;

final class CallbackAsset extends AbstractAsset
{
    /** @var callable */
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function getData(): string
    {
        return call_user_func($this->callable);
    }
}
