<?php
declare(strict_types = 1);

namespace App\Domain\Entity;

use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: UserRepositoryInterface::class)]
#[Table(name: 'user')]
final readonly class User
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true, options: ['comment' => 'DC2Type:ulid'])]
    private Ulid $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, length: 255)]
    #[Gedmo\Timestampable(on: 'create')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, length: 255)]
    #[Gedmo\Timestampable(on: 'update')]
    private \DatetimeImmutable $updatedAt;

    public function __construct(
        string $email,
        string $name,
    ) {
        $this->id    = new Ulid();
        $this->email = $email;
        $this->name  = $name;
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DatetimeImmutable
    {
        return $this->updatedAt;
    }
}
