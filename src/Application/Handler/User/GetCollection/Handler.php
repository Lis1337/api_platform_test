<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\GetCollection;

use App\Application\Mapper\UserDtoMapper;
use App\Domain\Repository\UserRepositoryInterface;

final readonly class Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserDtoMapper $userDtoMapper,
    ) {
    }

    public function execute(Command $command): Response
    {
        $offset = ($command->page - 1) * $command->itemsPerPage;

        $users = $this->userRepository->findPage($offset, $command->itemsPerPage);

        return new Response(
            array_map(
                fn ($user) => $this->userDtoMapper->mapEntityToDto($user),
                $users,
            ),
            $this->userRepository->countAll(),
        );
    }
}
