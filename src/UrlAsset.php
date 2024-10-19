<?php

declare(strict_types=1);

namespace Endroid\Asset;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;

final readonly class UrlAsset extends AbstractAsset
{
    public function __construct(
        private string $url
    ) {
    }

    public function getData(): string
    {
        $client = HttpClient::create();

        try {
            $data = $client->request(Request::METHOD_GET, $this->url)->getContent();
        } catch (\Exception) {
            throw new \Exception(sprintf('Could not load data from URL "%s"', $this->url));
        }

        return $data;
    }
}
