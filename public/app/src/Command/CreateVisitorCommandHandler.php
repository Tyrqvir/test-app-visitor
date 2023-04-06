<?php

declare(strict_types=1);

namespace App\Command;

use App\Common\CQRS\Handler\Contracts\CommandHandlerInterface;
use App\Repository\VisitRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
class CreateVisitorCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly VisitRepositoryInterface $visitRepository
    ) {
    }

    public function __invoke(CreateVisitorCommand $command)
    {
        $this->visitRepository->incrementVisits($command->getCountryCode());
    }
}
