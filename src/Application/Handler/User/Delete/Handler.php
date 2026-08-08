<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\Delete;

use App\Domain\Repository\UserRepositoryInterface;

final readonly class Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function execute(Command $command): void
    {
        $this->userRepository->remove(
            $this->userRepository->findById($command->id),
        );
    }
}
