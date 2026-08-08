<?php
declare(strict_types = 1);
namespace App\Infrastructure\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Handler\User\Create\Command;
use App\Application\Handler\User\Create\Handler;

final readonly class UserCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private Handler $userCreateHandler,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): void {
        $this->userCreateHandler->execute(new Command(
            $data->email,
            $data->name,
        ));
    }
}
