<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Asset;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;

final class UrlAsset extends AbstractAsset
{
    /** @var string */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getData(): string
    {
        $client = HttpClient::create();

        try {
            $data = $client->request(Request::METHOD_GET, $this->url)->getContent();
        } catch (\Exception $exception) {
            throw new \Exception(sprintf('Could not load data from URL "%s"', $this->url));
        }

        return $data;
    }
}
