<?php
declare(strict_types = 1);
namespace App\Tests\Functional\User;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Tests\Support\FunctionalTester;
use Codeception\Test\Unit;
use Symfony\Component\Uid\Ulid;

final class GetUserTest extends Unit
{
    protected FunctionalTester $tester;

    public function testGetExistingUserReturnsUserData(): void
    {
        $user = new User('get-user@example.com', 'Get User');

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->tester->grabService(UserRepositoryInterface::class);
        $userRepository->save($user);

        $this->tester->sendGet('/api/users/' . $user->getId()->toRfc4122());

        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseContainsJson([
            'id'    => $user->getId()->toRfc4122(),
            'email' => 'get-user@example.com',
            'name'  => 'Get User',
        ]);

        $userRepository->remove($user);
    }

    public function testGetNonExistingUserReturns404(): void
    {
        $this->tester->sendGet('/api/users/' . (new Ulid())->toRfc4122());

        $this->tester->seeResponseCodeIs(404);
        $this->tester->seeResponseContainsJson([
            'detail' => 'User not found',
        ]);
    }
}
