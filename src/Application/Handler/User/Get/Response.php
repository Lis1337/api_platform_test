<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\Get;

use App\Application\Dto\User\UserDto;

final readonly class Response
{
    public function __construct(
        public UserDto $userDto,
    ) {
    }
}
