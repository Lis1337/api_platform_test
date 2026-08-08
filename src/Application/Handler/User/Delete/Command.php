<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\Delete;

use Symfony\Component\Uid\Ulid;

final readonly class Command
{
    public function __construct(
        public readonly Ulid $id,
    ) {
    }
}
