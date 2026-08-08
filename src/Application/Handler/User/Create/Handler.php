<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\Create;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;

final readonly class Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function execute(Command $command): void
    {
        $user = new User(
            $command->email,
            $command->name,
        );

        $this->userRepository->save($user);
    }
}
