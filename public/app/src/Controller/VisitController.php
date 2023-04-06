<?php

declare(strict_types=1);

namespace App\Controller;

use App\Annotation\Get;
use App\Annotation\Post;
use App\ArgumentResolver\Body;
use App\Enum\SerializedGroup;
use App\Message\Command\Visitor\CreateVisitorCommand;
use App\Message\Query\Visitor\VisitorListQuery;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

#[Route(path: '/visits', name: 'visits_')]
class VisitController extends AbstractBaseController
{
    #[Get(path: '', name: 'list')]
    public function getVisitList(): Response
    {
        $items = $this->cache->get($this->parameterBag->get('list-visitor-cache-key'), function (ItemInterface $item) {
            $item->expiresAfter($this->parameterBag->get('list-visitor-ttl'));

            $query = new VisitorListQuery();

            return $this->queryBus->handle($query);
        });

        return $this->readResponse($items);
    }

    #[OA\Post(
        description: 'Create visitor',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: CreateVisitorCommand::class, groups: [SerializedGroup::CREATE])
            )
        ),
        tags: ['membership'],
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: 'Request accepted'
            ),
        ]
    )]
    #[Post(path: '', name: 'createOrUpdate')]
    public function updateStatistic(#[Body] CreateVisitorCommand $command): Response
    {
        $this->commandBus->dispatch($command);

        return $this->asyncCreateResponse();
    }
}
