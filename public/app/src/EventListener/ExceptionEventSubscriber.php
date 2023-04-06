<?php

declare(strict_types=1);

namespace App\EventListener;

use JetBrains\PhpStorm\ArrayShape;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Validator\ConstraintViolation;

class ExceptionEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly LoggerInterface $commandValidationLogger)
    {
    }

    #[ArrayShape([KernelEvents::EXCEPTION => 'string'])]
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => ''];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationFailedException) {
            $message = '';

            /** @var ConstraintViolation $violation */
            foreach ($exception->getViolations() as $violation) {
                $message .= sprintf(
                    'Error on field: %s, message : %s'.\PHP_EOL,
                    $violation->getPropertyPath(),
                    $violation->getMessage()
                );
            }
        } else {
            $message = sprintf(
                'Error: %s with code: %s',
                $exception->getMessage(),
                $exception->getCode()
            );
        }

        $response = new Response();
        $response->setContent($message);

        switch (true) {
            case $exception instanceof HttpExceptionInterface:
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());

                break;

            case $exception instanceof NotNormalizableValueException
            || $exception instanceof MissingConstructorArgumentException
            || $exception instanceof ValidationFailedException:
                $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
                $this->commandValidationLogger->info($exception->getMessage());

                break;

            case $exception instanceof UnrecoverableMessageHandlingException:
                $response->setStatusCode(Response::HTTP_CONFLICT);

                break;

            default:
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

                break;
        }

        $event->setResponse($response);
    }
}
