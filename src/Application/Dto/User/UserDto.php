<?php
declare(strict_types = 1);
namespace App\Application\Dto\User;

use Symfony\Component\Uid\Ulid;

final readonly class UserDto
{
    public function __construct(
        public Ulid $id,
        public string $email,
        public string $name,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }
}
