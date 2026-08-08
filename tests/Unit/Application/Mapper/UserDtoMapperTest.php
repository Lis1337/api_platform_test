<?php
declare(strict_types = 1);
namespace App\Tests\Unit\Application\Mapper;

use App\Application\Mapper\UserDtoMapper;
use App\Domain\Entity\User;
use Codeception\Test\Unit;
use Symfony\Component\Uid\Ulid;

final class UserDtoMapperTest extends Unit
{
    private UserDtoMapper $mapper;

    protected function _before(): void
    {
        $this->mapper = new UserDtoMapper();
    }

    public function testMapEntityToDtoMapsAllFields(): void
    {
        $id        = new Ulid();
        $createdAt = new \DateTimeImmutable('2026-01-01T00:00:00+00:00');
        $updatedAt = new \DateTimeImmutable('2026-01-02T00:00:00+00:00');

        $user = $this->createUser($id, 'user@example.com', 'John Doe', $createdAt, $updatedAt);

        $dto = $this->mapper->mapEntityToDto($user);

        $this->assertNotNull($dto);
        $this->assertSame($id, $dto->id);
        $this->assertSame('user@example.com', $dto->email);
        $this->assertSame('John Doe', $dto->name);
        $this->assertSame($createdAt, $dto->createdAt);
        $this->assertSame($updatedAt, $dto->updatedAt);
    }

    public function testMapEntityToDtoReturnsNullForNull(): void
    {
        $this->assertNull($this->mapper->mapEntityToDto(null));
    }

    /**
     * User::$createdAt/$updatedAt заполняются только Gedmo\Timestampable во время
     * Doctrine-флаша, поэтому для чистого юнит-теста собираем сущность через
     * рефлексию, а не через конструктор.
     */
    private function createUser(
        Ulid $id,
        string $email,
        string $name,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): User {
        $reflection = new \ReflectionClass(User::class);
        /** @var User $user */
        $user = $reflection->newInstanceWithoutConstructor();

        $reflection->getProperty('id')->setValue($user, $id);
        $reflection->getProperty('email')->setValue($user, $email);
        $reflection->getProperty('name')->setValue($user, $name);
        $reflection->getProperty('createdAt')->setValue($user, $createdAt);
        $reflection->getProperty('updatedAt')->setValue($user, $updatedAt);

        return $user;
    }
}
