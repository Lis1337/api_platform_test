<?php
declare(strict_types = 1);
namespace App\Domain\Repository;

use App\Domain\Entity\House;
use Symfony\Component\Uid\Ulid;

interface HouseRepositoryInterface
{
    public function findById(Ulid $id): ?House;

    public function save(House $house): void;
}
