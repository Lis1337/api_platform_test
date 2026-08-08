<?php
declare(strict_types = 1);
namespace App\Infrastructure\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Handler\User\Delete\Command;
use App\Application\Handler\User\Delete\Handler;
use Symfony\Component\Uid\Ulid;

final readonly class UserDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private Handler $userDeleteHandler,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->userDeleteHandler->execute(new Command(
            Ulid::fromString($uriVariables['id']),
        ));
    }
}
