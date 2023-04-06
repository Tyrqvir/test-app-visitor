<?php

declare(strict_types=1);

namespace App\Common\CQRS\MessageBus\Contracts;

use Symfony\Component\Messenger\Envelope;

interface EventBusInterface
{
    public function dispatch(Envelope $event): void;
}
