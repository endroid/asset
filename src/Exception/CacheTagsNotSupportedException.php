<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset\Exception;

final class CacheTagsNotSupportedException extends AssetException
{
    public static function create(): self
    {
        return new self('You are using a non tag-aware cache pool. Please use an adapter that implements TagAwareAdapterInterface or avoid using tags.');
    }
}
