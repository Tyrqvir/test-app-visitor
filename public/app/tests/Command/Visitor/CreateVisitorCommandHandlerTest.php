<?php

declare(strict_types=1);

namespace App\Tests\Command\Visitor;

use App\Message\Command\Visitor\CreateVisitorCommand;
use App\Message\Command\Visitor\CreateVisitorCommandHandler;
use App\Repository\VisitRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Middleware\ValidationMiddleware;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class CreateVisitorCommandHandlerTest extends KernelTestCase
{
    private VisitRepositoryInterface $visitRepository;

    private CreateVisitorCommandHandler $handler;

    protected function setUp(): void
    {
        $this->visitRepository = $this->createMock(VisitRepositoryInterface::class);
        $this->handler = new CreateVisitorCommandHandler($this->visitRepository);
    }

    public function testHandleIncrementsVisits(): void
    {
        $countryCode = 'US';
        $command = new CreateVisitorCommand($countryCode);

        $this->visitRepository
            ->expects($this->once())
            ->method('incrementVisits')
            ->with($countryCode)
        ;

        ($this->handler)($command);
    }

    public function testHandleThrowsExceptionWithInvalidCountryCode(): void
    {
        $this->expectException(ValidationFailedException::class);

        self::bootKernel();
        $container = static::getContainer();

        $message = new CreateVisitorCommand('invalid-code');
        $envelope = new Envelope($message);

        /** @var ValidatorInterface $validator */
        $validator = $container->get(ValidatorInterface::class);
        $middleware = new ValidationMiddleware($validator);
        $middleware->handle($envelope, $this->createMock(StackInterface::class));
    }
}
