<?php
declare(strict_types = 1);
namespace App\Tests\Functional\User;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Tests\Support\FunctionalTester;
use Codeception\Test\Unit;
use Symfony\Component\Uid\Ulid;

final class DeleteUserTest extends Unit
{
    protected FunctionalTester $tester;

    public function testDeleteExistingUserReturns204(): void
    {
        $user = new User('delete-user@example.com', 'Delete User');

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->tester->grabService(UserRepositoryInterface::class);
        $userRepository->save($user);

        $this->tester->sendDelete('/api/users/' . $user->getId()->toRfc4122());

        $this->tester->seeResponseCodeIs(204);
    }

    public function testDeleteNonExistingUserReturns404(): void
    {
        $this->tester->sendDelete('/api/users/' . (new Ulid())->toRfc4122());

        $this->tester->seeResponseCodeIs(404);
        $this->tester->seeResponseContainsJson([
            'detail' => 'User not found',
        ]);
    }
}
