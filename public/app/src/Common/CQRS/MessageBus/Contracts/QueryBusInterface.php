<?php

declare(strict_types=1);

namespace App\Common\CQRS\MessageBus\Contracts;

use App\Common\CQRS\Message\Contracts\QueryMessageInterface;

interface QueryBusInterface
{
    public function handle(QueryMessageInterface $query): mixed;
}
