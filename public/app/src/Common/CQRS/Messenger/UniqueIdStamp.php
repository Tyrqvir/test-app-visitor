<?php

declare(strict_types=1);

namespace App\Common\CQRS\Messenger;

use Symfony\Component\Messenger\Stamp\StampInterface;

class UniqueIdStamp implements StampInterface
{
    private readonly string $uniqueId;

    public function __construct()
    {
        $this->uniqueId = uniqid('', true);
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }
}
