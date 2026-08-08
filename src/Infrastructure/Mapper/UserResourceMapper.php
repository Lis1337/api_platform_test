<?php
declare(strict_types = 1);
namespace App\Infrastructure\Mapper;

use App\Application\Dto\User\UserDto;
use App\Infrastructure\Resource\User as UserResource;

final readonly class UserResourceMapper
{
    public function mapDtoToResource(?UserDto $user): ?UserResource
    {
        if (null === $user) {
            return null;
        }

        $result = new UserResource();

        $result->id = $user->id->toRfc4122();
        $result->email = $user->email;
        $result->name = $user->name;
        $result->createdAt = $user->createdAt;
        $result->updatedAt = $user->updatedAt;

        return $result;
    }
}
