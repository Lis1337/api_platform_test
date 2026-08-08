<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\GetCollection;

final readonly class Command
{
    public function __construct(
        public readonly int $page,
        public readonly int $itemsPerPage,
    ) {
    }
}
