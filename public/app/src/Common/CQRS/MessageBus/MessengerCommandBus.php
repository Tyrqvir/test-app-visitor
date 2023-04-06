<?php

declare(strict_types=1);

namespace App\Common\CQRS\MessageBus;

use App\Common\CQRS\Message\Contracts\CommandMessageInterface;
use App\Common\CQRS\Message\Contracts\SyncCommandMessageInterface;
use App\Common\CQRS\MessageBus\Contracts\CommandBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class MessengerCommandBus implements CommandBusInterface
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    /**
     * @throws Throwable
     */
    public function dispatch(CommandMessageInterface|SyncCommandMessageInterface $command): void
    {
        try {
            $this->commandBus->dispatch($command);
        } catch (Throwable $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }

            throw $e;
        }
    }
}
