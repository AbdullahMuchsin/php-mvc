<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Middleware;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Service\SessionService;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\View;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;

class MustNotLoginMiddleware implements Middleware
{

    private SessionService $sessionService;

    public function __construct()
    {
        $userRepository = new UserRepository(Database::getConnection());
        $sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function before(): void {
        $user = $this->sessionService->current();

        if($user != null) {
            View::redirect("/");
        }
    }
}
