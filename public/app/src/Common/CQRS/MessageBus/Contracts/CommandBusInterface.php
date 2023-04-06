<?php

declare(strict_types=1);

namespace App\Common\CQRS\MessageBus\Contracts;

use App\Common\CQRS\Message\Contracts\CommandMessageInterface;
use App\Common\CQRS\Message\Contracts\SyncCommandMessageInterface;

interface CommandBusInterface
{
    public function dispatch(CommandMessageInterface|SyncCommandMessageInterface $command): void;
}
