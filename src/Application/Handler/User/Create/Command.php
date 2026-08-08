<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\Create;

final readonly class Command
{
    public function __construct(
        public readonly string $email,
        public readonly string $name,
    ) {
    }
}
