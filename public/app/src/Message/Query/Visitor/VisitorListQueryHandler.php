<?php

declare(strict_types=1);

namespace App\Message\Query\Visitor;

use App\Common\CQRS\Handler\Contracts\QueryHandlerInterface;
use App\Repository\VisitRepositoryInterface;
use App\Service\VisitorServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final class VisitorListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly VisitRepositoryInterface $repository,
        private readonly VisitorServiceInterface $visitorService
    ) {
    }

    public function __invoke(VisitorListQuery $query): array
    {
        $result = [];

        $countryCodes = $this->visitorService->getCountryCodes();

        foreach ($this->repository->findValueByCodes($countryCodes) as $i => $count) {
            $countryCode = $countryCodes[$i];
            $result[$countryCode] = $count;
        }

        return $result;
    }
}
