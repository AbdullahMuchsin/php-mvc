<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Service;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\Session;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

function setcookie(string $name, string $value)
{
    echo "$name : $value";
}

class SessionServiceTest extends TestCase
{

    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
    private SessionService $sessionService;

    public function setUp(): void
    {
        $connection = Database::getConnection();

        $this->userRepository = new UserRepository($connection);
        $this->sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = "rahasia";

        $this->userRepository->save($user);
    }

    public function testCreate()
    {
        $user_id = "muchsin";
        $session = $this->sessionService->create($user_id);

        $this->expectOutputRegex("[X-ABD-SESSION : $session->id]");

        $user = $this->sessionRepository->findById($session->id);

        Assert::assertEquals($user_id, $user->user_id);
    }

    public function testDestroy()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->user_id = "muchsin";

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->sessionService->destroy();

        $this->expectOutputRegex("[X-ABD-SESSION : ]");

        $result = $this->sessionRepository->findById($session->id);

        Assert::assertNull($result);
    }

    public function testCurrent()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->user_id = "muchsin";

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $user = $this->sessionService->current();

        Assert::assertEquals($session->user_id, $user->id);
    }
}
