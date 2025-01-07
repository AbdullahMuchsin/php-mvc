<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\Controller;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Exception\ValidationException;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserLoginRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserRegisterRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Service\SessionService;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Service\UserService;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\View;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;

class UserController
{
    private UserService $service;
    private SessionService $session;

    public function __construct()
    {
        $connection = Database::getConnection();
        $repository = new UserRepository($connection);
        $this->service = new UserService($repository);
        $sessionRepository = new SessionRepository($connection);
        $this->session = new SessionService($sessionRepository, $repository);
    }

    public function register()
    {
        $model = [
            "title" => "User New Register",
        ];

        View::render('header', $model);
        View::render('user/register');
        View::render('footer');
    }

    public function postRegister()
    {
        $request = new UserRegisterRequest();
        $request->id = $_POST["id"];
        $request->name = $_POST["name"];
        $request->password = $_POST["password"];

        try {
            $this->service->register($request);

            // Redirect to login page
            View::redirect("/login");
        } catch (ValidationException $exception) {
            $model = [
                "title" => "User Register",
                "error" => $exception->getMessage(),
            ];

            View::render('header', $model);
            View::render('user/register', $model);
            View::render('footer');
        }
    }

    public function login()
    {
        $model = [
            "title" => "Login User"
        ];

        View::render("header", $model);
        View::render("user/login");
        View::render("footer");
    }

    public function postLogin()
    {

        $request = new UserLoginRequest();
        $request->id = $_POST["id"];
        $request->password = $_POST["password"];

        try {
            $respone = $this->service->login($request);

            $this->session->create($respone->user->id);

            View::redirect("/");
        } catch (ValidationException $exception) {
            $model = [
                "title" => "Login User",
                "error" => $exception->getMessage(),
            ];

            View::render("header", $model);
            View::render("user/login", $model);
            View::render("footer");
        }
    }
}
