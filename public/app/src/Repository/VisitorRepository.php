<?php

declare(strict_types=1);

namespace App\Repository;

use Iterator;
use Predis\Client;

class VisitorRepository implements VisitRepositoryInterface
{
    public function __construct(private readonly Client $client)
    {
    }

    public function incrementVisits(string $countryCode): void
    {
        $countryCodeWithPrefix = $countryCode;

        $this->client->incr($countryCodeWithPrefix);
    }

    public function initCountryCodes(array $countryCodes): void
    {
        foreach ($countryCodes as $code) {
            $this->client->set($code, 0);
        }
    }

    public function findValueByCodes(array $countryCodes): Iterator
    {
        $items = $this->client->mget($countryCodes);

        foreach ($items as $val) {
            yield (int) $val;
        }
    }
}
