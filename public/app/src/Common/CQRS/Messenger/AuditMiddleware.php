<?php

declare(strict_types=1);

namespace App\Common\CQRS\Messenger;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

class AuditMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly LoggerInterface $messengerAuditLogger)
    {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null === $envelope->last(UniqueIdStamp::class)) {
            $envelope = $envelope->with(new UniqueIdStamp());
        }

        /** @var UniqueIdStamp $stamp */
        $stamp = $envelope->last(UniqueIdStamp::class);

        $context = [
            'id' => $stamp->getUniqueId(),
            'class' => $envelope->getMessage()::class,
        ];

        $envelope = $stack->next()->handle($envelope, $stack);

        if ($envelope->last(ReceivedStamp::class)) {
            $this->messengerAuditLogger->info('[{id}] Received {class}', $context);
        } elseif ($envelope->last(SentStamp::class)) {
            $this->messengerAuditLogger->info('[{id}] Sent {class}', $context);
        } else {
            $this->messengerAuditLogger->info('[{id}] Handling sync {class}', $context);
        }

        return $envelope;
    }
}
