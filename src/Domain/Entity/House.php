<?php
declare(strict_types = 1);
namespace App\Domain\Entity;

use App\Domain\Repository\HouseRepositoryInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: HouseRepositoryInterface::class)]
#[ORM\Table(name: 'house')]
final class House
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true, options: ['comment' => 'DC2Type:ulid'])]
    private Ulid $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private int $floorNumber;

    /**
     * @param string $name
     * @param int    $floorNumber
     */
    public function __construct(string $name, int $floorNumber)
    {
        $this->id          = new Ulid();
        $this->name        = $name;
        $this->floorNumber = $floorNumber;
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFloorNumber(): int
    {
        return $this->floorNumber;
    }

    public function setFloorNumber(int $floorNumber): void
    {
        $this->floorNumber = $floorNumber;
    }
}
