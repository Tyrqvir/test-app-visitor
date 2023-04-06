<?php

declare(strict_types=1);

namespace App\Service;

interface VisitorServiceInterface
{
    public function initCountryCodes(): void;

    public function getCountryCodes(): array;
}
