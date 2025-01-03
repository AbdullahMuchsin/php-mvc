<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{

    private UserRepository $userRepository;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSave()
    {
        $user = new User();
        $user->id = "1";
        $user->name = "Abdullah Muchsin";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->id);

        Assert::assertEquals($user->id, $result->id);
        Assert::assertEquals($user->name, $result->name);
        Assert::assertEquals($user->password, $result->password);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->userRepository->findById("1");

        Assert::assertNull($result);
    }
}
