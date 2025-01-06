<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\Session;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{

    private SessionRepository $sessionRepository;

    public function setUp(): void
    {
        $connection = Database::getConnection();
        $this->sessionRepository = new SessionRepository($connection);

        $this->sessionRepository->deleteAll();
    }

    public function testSessionSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->user_id = "muchsin";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);

        Assert::assertEquals($session->id, $result->id);
        Assert::assertEquals($session->user_id, $result->user_id);
    }

    public function testSessionDeleteByIdSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->user_id = "muchsin";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);

        Assert::assertEquals($session->id, $result->id);
        Assert::assertEquals($session->user_id, $result->user_id);

        $this->sessionRepository->deleteById($session->id);

        $result = $this->sessionRepository->findById($session->id);

        Assert::assertNull($result);
    }

    public function testSessionNotFound()
    {
        $result = $this->sessionRepository->findById("notfound");

        Assert::assertNull($result);
    }
}
