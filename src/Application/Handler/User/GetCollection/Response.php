<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\GetCollection;

use App\Application\Dto\User\UserDto;

final readonly class Response
{
    /**
     * @param UserDto[] $userDtos
     */
    public function __construct(
        public array $userDtos,
        public int $totalItems,
    ) {
    }
}
