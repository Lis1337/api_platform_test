<?php
declare(strict_types = 1);
namespace App\Infrastructure\Repository;

use App\Domain\Entity\House;
use App\Domain\Repository\HouseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;

final class HouseRepository extends ServiceEntityRepository implements HouseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, House::class);
    }

    public function findById(Ulid $id): ?House
    {
        return $this->find($id);
    }

    public function save(House $house): void
    {
        $this->getEntityManager()->persist($house);
        $this->getEntityManager()->flush();
    }
}
