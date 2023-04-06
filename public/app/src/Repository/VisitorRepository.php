<?php

declare(strict_types=1);

namespace App\Repository;

use App\Enum\VisitorEnum;
use Predis\Client;
use Predis\Collection\Iterator\Keyspace;

class VisitorRepository implements VisitRepositoryInterface
{
    public function __construct(private readonly Client $client)
    {
    }

    public function incrementVisits(string $countryCode): void
    {
        $countryCodeWithPrefix = VisitorEnum::STORAGE_COUNTRY_CODE_PREFIX->value.$countryCode;

        if ($this->client->exists($countryCodeWithPrefix)) {
            $this->client->incr($countryCodeWithPrefix);
        } else {
            $this->client->set($countryCodeWithPrefix, 1);
        }
    }

    public function findAll(): \Iterator
    {
        $pattern = VisitorEnum::STORAGE_COUNTRY_CODE_PREFIX->value.'*';

        foreach (new Keyspace($this->client, $pattern) as $key) {
            yield [$key, $this->client->get($key)];
        }
    }
}
