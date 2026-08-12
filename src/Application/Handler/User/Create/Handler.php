<?php
declare(strict_types = 1);
namespace App\Application\Handler\User\Create;

use App\Domain\Entity\User;
use App\Domain\Repository\HouseRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Uid\Ulid;

final readonly class Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private HouseRepositoryInterface $houseRepository,
    ) {
    }

    public function execute(Command $command): void
    {
        $user = new User(
            $command->email,
            $command->name,
        );

        // House читается из БД, а значит попадает под управление EntityManager
        // и его исходное состояние запоминается в UnitOfWork.
        $house = $this->houseRepository->findById(
            Ulid::fromRfc4122('019ff43f-2fad-6ec5-4a72-6a22d2864f92'),
        );

        // Меняем House просто «по ходу дела»: persist() не зовём и сохранять его не собираемся.
        $house?->setFloorNumber($house->getFloorNumber() + 1);

        // А вот здесь ловушка: flush() внутри save() не сохраняет один переданный объект,
        // он сверяет с исходным состоянием ВСЕ управляемые сущности. House изменился —
        // значит вместе с INSERT INTO user уедет и UPDATE house, о котором мы не просили.
        $this->userRepository->save($user);
    }
}
