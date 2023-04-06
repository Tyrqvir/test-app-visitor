<?php

declare(strict_types=1);

namespace App\Query\Visitor;

use App\Common\CQRS\Handler\Contracts\QueryHandlerInterface;
use App\Enum\VisitorEnum;
use App\Repository\VisitRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final class VisitorListQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly VisitRepositoryInterface $repository)
    {
    }

    public function __invoke(VisitorListQuery $query): array
    {
        $result = [];

        foreach ($this->repository->findAll() as $composite) {
            [$countryCode, $viewCount] = $composite;

            $outputKey = str_replace(VisitorEnum::STORAGE_COUNTRY_CODE_PREFIX->value, '', (string) $countryCode);

            $result[$outputKey] = (int) $viewCount;
        }

        return $result;
    }
}
