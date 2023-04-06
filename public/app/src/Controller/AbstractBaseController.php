<?php

declare(strict_types=1);

namespace App\Controller;

use App\Common\CQRS\MessageBus\Contracts\CommandBusInterface;
use App\Common\CQRS\MessageBus\Contracts\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

abstract class AbstractBaseController extends AbstractController
{
    public function __construct(
        protected QueryBusInterface $queryBus,
        protected CommandBusInterface $commandBus,
        protected TagAwareCacheInterface $cache,
        protected ParameterBagInterface $parameterBag,
    ) {
    }

    protected function readResponse(mixed $data, array $group = [], array $headers = []): JsonResponse
    {
        return $this->json($data, Response::HTTP_OK, $headers, [
            'groups' => $group,
        ]);
    }

    protected function asyncCreateResponse(): JsonResponse
    {
        return $this->json(null, Response::HTTP_ACCEPTED);
    }

    protected function syncCreateResponse(): JsonResponse
    {
        return $this->json(null, Response::HTTP_CREATED);
    }
}
