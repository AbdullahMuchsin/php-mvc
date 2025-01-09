<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\Controller;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\Session;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Service\SessionService;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{

    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;
    private HomeController $homeController;

    public function setUp(): void
    {
        $this->homeController = new HomeController();
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testGuest()
    {
        $this->homeController->index();

        $this->expectOutputRegex("[Silakan pilih untuk Login atau Register]");
    }

    public function testUserLogin()
    {
        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $user = $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->user_id = $user->id;
        
        $_COOKIE[SessionService::$COOKIE_NAME] =  $session->id;

        $this->sessionRepository->save($session);

        $this->homeController->index();

        $this->expectOutputRegex("[Hello, $user->name]");
    }
}
