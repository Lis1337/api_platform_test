<?php
declare(strict_types = 1);
namespace App\Tests\Functional\User;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Tests\Support\FunctionalTester;
use Codeception\Test\Unit;

final class GetCollectionUserTest extends Unit
{
    protected FunctionalTester $tester;

    /** @var User[] */
    private array $users = [];

    protected function _before(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->tester->grabService(UserRepositoryInterface::class);

        for ($i = 1; $i <= 3; ++$i) {
            $user = new User("collection-user-{$i}@example.com", "Collection User {$i}");
            $userRepository->save($user);
            $this->users[] = $user;
        }
    }

    protected function _after(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->tester->grabService(UserRepositoryInterface::class);

        foreach ($this->users as $user) {
            $userRepository->remove($user);
        }
    }

    public function testGetCollectionRespectsItemsPerPageAndReturnsPaginationMetadata(): void
    {
        $this->tester->haveHttpHeader('Accept', 'application/ld+json');
        $this->tester->sendGet('/api/users?itemsPerPage=2&page=1');

        $this->tester->seeResponseCodeIs(200);

        $totalItems = $this->tester->grabDataFromResponseByJsonPath('$.totalItems')[0];
        $members    = $this->tester->grabDataFromResponseByJsonPath('$.member')[0];
        $view       = $this->tester->grabDataFromResponseByJsonPath('$.view')[0];

        $this->assertGreaterThanOrEqual(3, $totalItems);
        $this->assertCount(2, $members);
        $this->assertSame('/api/users?itemsPerPage=2&page=1', $view['@id']);
        $this->assertArrayHasKey('next', $view);
    }
}
