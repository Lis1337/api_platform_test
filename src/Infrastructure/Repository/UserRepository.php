<?php
declare(strict_types = 1);
namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\Exception\UserNotFoundException;
use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;

/**
 * @extends ServiceEntityRepository<User>
 */
final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, User::class);
    }

    public function findById(Ulid $id): User
    {
        return $this->find($id) ?? throw new UserNotFoundException();
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function remove(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
