<?php
declare(strict_types = 1);
namespace App\Tests\Unit\Infrastructure\Mapper;

use App\Application\Dto\User\UserDto;
use App\Infrastructure\Mapper\UserResourceMapper;
use Codeception\Test\Unit;
use Symfony\Component\Uid\Ulid;

final class UserResourceMapperTest extends Unit
{
    private UserResourceMapper $mapper;

    protected function _before(): void
    {
        $this->mapper = new UserResourceMapper();
    }

    public function testMapDtoToResourceMapsAllFields(): void
    {
        $id        = new Ulid();
        $createdAt = new \DateTimeImmutable('2026-01-01T00:00:00+00:00');
        $updatedAt = new \DateTimeImmutable('2026-01-02T00:00:00+00:00');

        $dto = new UserDto($id, 'user@example.com', 'John Doe', $createdAt, $updatedAt);

        $resource = $this->mapper->mapDtoToResource($dto);

        $this->assertNotNull($resource);
        $this->assertSame($id->toRfc4122(), $resource->id);
        $this->assertSame('user@example.com', $resource->email);
        $this->assertSame('John Doe', $resource->name);
        $this->assertSame($createdAt, $resource->createdAt);
        $this->assertSame($updatedAt, $resource->updatedAt);
    }

    public function testMapDtoToResourceReturnsNullForNull(): void
    {
        $this->assertNull($this->mapper->mapDtoToResource(null));
    }
}
