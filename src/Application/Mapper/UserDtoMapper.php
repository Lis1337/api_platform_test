<?php
declare(strict_types = 1);
namespace App\Application\Mapper;

use App\Application\Dto\User\UserDto;
use App\Domain\Entity\User;

final readonly class UserDtoMapper
{
    public function mapEntityToDto(?User $user): ?UserDto
    {
        if (null === $user) {
            return null;
        }

        return new UserDto(
            $user->getId(),
            $user->getEmail(),
            $user->getName(),
            $user->getCreatedAt(),
            $user->getUpdatedAt(),
        );
    }
}
