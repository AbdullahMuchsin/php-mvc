<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\Controller;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Service\SessionService;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\View;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;

class HomeController
{

    private SessionService $sessionService;

    public function __construct()
    {
        $userRepository = new UserRepository(Database::getConnection());
        $sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function index(): void
    {
        $user = $this->sessionService->current();

        if ($user == null) {
            $model = [
                'title' => 'Login Management',
            ];

            View::render("header", $model);
            View::render("home/index");
            View::render("footer");
        } else {
            $model = [
                'title' => 'Dashboard',
                'user' => [
                    "name" => $user->name,
                ]
            ];

            View::render("header", $model);
            View::render("home/dashboard", $model);
            View::render("footer");
        }
    }
}
