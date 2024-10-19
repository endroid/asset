<?php

declare(strict_types=1);

namespace Endroid\Asset;

final readonly class MultiUrlAsset extends AbstractAsset
{
    public function __construct(
        /** @var array<string> */
        private array $urls,
    ) {
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
            $data[$key] = curl_multi_getcontent($handle);
            if (0 !== curl_errno($handle)) {
                throw new \RuntimeException(sprintf('Error while downloading "%s": %s', $this->urls[$key], curl_error($handle)));
            }
        }

        return serialize($data);
    }
}
