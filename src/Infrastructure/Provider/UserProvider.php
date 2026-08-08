<?php
declare(strict_types = 1);
namespace App\Infrastructure\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Handler\User\Get\Command;
use App\Application\Handler\User\Get\Handler;
use App\Infrastructure\Mapper\UserResourceMapper;
use Symfony\Component\Uid\Ulid;

final readonly class UserProvider implements ProviderInterface
{
    public function __construct(
        private Handler $userGetHandler,
        private UserResourceMapper $userResourceMapper,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|null
    {
        $userId = $uriVariables['id'];

        $userDto = $this->userGetHandler->execute(new Command(
            Ulid::fromString($userId),
        ))->userDto;

        return $this->userResourceMapper->mapDtoToResource($userDto);
    }
}
