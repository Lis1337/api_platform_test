<?php
declare(strict_types = 1);
namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Exception\UserNotFoundException;
use Symfony\Component\Uid\Ulid;

interface UserRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function findById(Ulid $id): User;

    public function save(User $user): void;

    public function remove(User $user): void;
}
