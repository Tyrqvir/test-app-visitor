<?php

declare(strict_types=1);

namespace App\Common\CQRS\MessageBus;

use App\Common\CQRS\Message\Contracts\QueryMessageInterface;
use App\Common\CQRS\MessageBus\Contracts\QueryBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @throws Throwable
     */
    public function handle(QueryMessageInterface $query): mixed
    {
        try {
            return $this->handleQuery($query);
        } catch (Throwable $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }

            throw $e;
        }
    }
}
