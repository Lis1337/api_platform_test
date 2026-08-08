<?php
declare(strict_types = 1);
namespace App\Tests\Functional\User;

use App\Infrastructure\Repository\UserRepository;
use App\Tests\Support\FunctionalTester;
use Codeception\Test\Unit;

final class CreateUserTest extends Unit
{
    protected FunctionalTester $tester;

    public function testCreateUserPersistsUser(): void
    {
        $this->tester->haveHttpHeader('Content-Type', 'application/json');
        $this->tester->sendPost('/api/users', [
            'email' => 'create-user@example.com',
            'name'  => 'Create User',
        ]);

        $this->tester->seeResponseCodeIs(201);

        /** @var UserRepository $userRepository */
        $userRepository = $this->tester->grabService(UserRepository::class);
        $persisted       = $userRepository->findOneBy(['email' => 'create-user@example.com']);

        $this->assertNotNull($persisted);
        $this->assertSame('Create User', $persisted->getName());

        $userRepository->remove($persisted);
    }

    public function testCreateUserWithoutRequiredFieldsReturns422(): void
    {
        $this->tester->haveHttpHeader('Content-Type', 'application/json');
        $this->tester->sendPost('/api/users', []);

        $this->tester->seeResponseCodeIsClientError();
    }
}
