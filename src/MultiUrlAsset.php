<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

final class MultiUrlAsset extends AbstractAsset
{
    /** @var array<string> */
    private array $urls;

    /** @param array<string> $urls */
    public function __construct(array $urls)
    {
        $this->urls = $urls;
    }

    public function getData(): string
    {
        $handles = [];
        $multiHandle = curl_multi_init();
        foreach ($this->urls as $key => $url) {
            $handle = curl_init();
            curl_setopt_array($handle, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
            ]);
            curl_multi_add_handle($multiHandle, $handle);
            $handles[$key] = $handle;
        }

        do {
            curl_multi_exec($multiHandle, $active);
        } while ($active > 0);

        $data = [];
        foreach ($handles as $key => $handle) {
            $data[$key] = strval(curl_multi_getcontent($handle));
        }

        return serialize($data);
    }
}
