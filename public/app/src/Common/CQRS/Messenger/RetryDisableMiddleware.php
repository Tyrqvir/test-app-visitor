<?php

declare(strict_types=1);

namespace App\Common\CQRS\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Throwable;

class RetryDisableMiddleware implements MiddlewareInterface
{
    /**
     * Needed return "UnrecoverableMessageHandlingException" for disable retry.
     *
     * @throws Throwable
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        return $stack->next()->handle($envelope, $stack);
    }
}
