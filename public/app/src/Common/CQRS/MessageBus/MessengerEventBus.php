<?php

declare(strict_types=1);

namespace App\Common\CQRS\MessageBus;

use App\Common\CQRS\MessageBus\Contracts\EventBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventBus implements EventBusInterface
{
    public function __construct(private readonly MessageBusInterface $eventBus)
    {
    }

    public function dispatch(Envelope $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
