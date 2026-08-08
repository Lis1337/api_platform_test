<?php
declare(strict_types = 1);
namespace App\Infrastructure\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Application\Handler\User\GetCollection\Command;
use App\Application\Handler\User\GetCollection\Handler;
use App\Infrastructure\Mapper\UserResourceMapper;

final readonly class UserCollectionProvider implements ProviderInterface
{
    public function __construct(
        private Handler $userGetCollectionHandler,
        private UserResourceMapper $userResourceMapper,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): TraversablePaginator
    {
        $filters = $context['filters'] ?? [];

        $itemsPerPage = $operation->getPaginationItemsPerPage() ?? 30;

        if (true === $operation->getPaginationClientItemsPerPage() && isset($filters['itemsPerPage'])) {
            $itemsPerPage = (int) $filters['itemsPerPage'];
        }

        if (null !== $maximumItemsPerPage = $operation->getPaginationMaximumItemsPerPage()) {
            $itemsPerPage = min($itemsPerPage, $maximumItemsPerPage);
        }

        $itemsPerPage = max(1, $itemsPerPage);
        $page         = max(1, (int) ($filters['page'] ?? 1));

        $response = $this->userGetCollectionHandler->execute(new Command($page, $itemsPerPage));

        $resources = array_map(
            fn ($userDto) => $this->userResourceMapper->mapDtoToResource($userDto),
            $response->userDtos,
        );

        return new TraversablePaginator(
            new \ArrayIterator($resources),
            (float) $page,
            (float) $itemsPerPage,
            (float) $response->totalItems,
        );
    }
}
