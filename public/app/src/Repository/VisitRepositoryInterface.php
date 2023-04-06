<?php

declare(strict_types=1);

namespace App\Repository;

use Iterator;

interface VisitRepositoryInterface
{
    public function incrementVisits(string $countryCode): void;

    public function findAll(): Iterator;
}
