<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\Get;

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
        $user = $this->userRepository->findById($command->id);

        return new Response(
            $this->userDtoMapper->mapEntityToDto($user),
        );
    }
}
