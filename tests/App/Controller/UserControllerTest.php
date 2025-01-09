<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App {

    function header(string $value)
    {
        echo "Location: $value";
    }
}

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Service {
    function setcookie(string $name, string $value)
    {
        echo "$name: $value";
    }
}

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App {

    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\Session;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Service\SessionService;
    use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
    use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\UserController;
    use PHPUnit\Framework\TestCase;

    class UserControllerTest extends TestCase
    {
        private UserRepository $userRepository;
        private UserController $userController;
        private SessionRepository $sessionRepository;

        public function setUp(): void
        {
            $this->userController = new UserController();
            $this->userRepository = new UserRepository(Database::getConnection());
            $this->sessionRepository = new SessionRepository(Database::getConnection());

            $this->sessionRepository->deleteAll();
            $this->userRepository->deleteAll();

            putenv("mode=test");
        }

        public function testRegister()
        {
            $this->userController->register();

            $this->expectOutputRegex("[User New Register]");
            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Nama]");
            $this->expectOutputRegex("[Password]");
        }

        public function testPostRegisterSuccess()
        {
            $_POST["id"] = "eko";
            $_POST["name"] = "Abdullah Muchsin";
            $_POST["password"] = "rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[Location: /login]");
        }

        public function testPostRegisterValidationException()
        {
            $_POST["id"] = "";
            $_POST["name"] = "Abdullah Muchsin";
            $_POST["password"] = "rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[Id, Name, and Password not blank]");
            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Nama]");
            $this->expectOutputRegex("[Password]");
        }

        public function testPostRegisterDuplicate()
        {

            $user = new User();
            $user->id = "eko";
            $user->name = "Abdullah Muchsin";
            $user->password = "rahasia";

            $this->userRepository->save($user);

            $_POST["id"] = "eko";
            $_POST["name"] = "Abdullah Muchsin";
            $_POST["password"] = "rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[User Id already exists]");
            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Nama]");
            $this->expectOutputRegex("[Password]");
        }


        public function testLogin()
        {

            $this->userController->login();

            $this->expectOutputRegex("[Login User]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Password]");
        }

        public function testLoginSuccess()
        {
            $user = new User();
            $user->id = "muchsin";
            $user->name = "Abdullah Muchsin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $_POST["id"] = "muchsin";
            $_POST["password"] = "rahasia";

            $this->userController->postLogin();

            $nameCookie = SessionService::$COOKIE_NAME;

            $this->expectOutputRegex("[Location: /]");
            $this->expectOutputRegex("[$nameCookie: ]");
        }

        public function testLoginValidationError()
        {
            $_POST["id"] = "";
            $_POST["password"] = "";

            $this->userController->postLogin();

            $this->expectOutputRegex("[Id, and Password not blank]");
            $this->expectOutputRegex("[Login User]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Password]");
        }

        public function testLoginNotFound()
        {
            $_POST["id"] = "notfound";
            $_POST["password"] = "notfound";

            $this->userController->postLogin();

            $this->expectOutputRegex("[Id or Password is wrong]");
            $this->expectOutputRegex("[Login User]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Password]");
        }

        public function testLoginPasswordWrong()
        {
            $user = new User();
            $user->id = "muchsin";
            $user->name = "Abdullah Muchsin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $_POST["id"] = "muchsin";
            $_POST["password"] = "salah";

            $this->userController->postLogin();

            $this->expectOutputRegex("[Id or Password is wrong]");
            $this->expectOutputRegex("[Login User]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Password]");
        }

        public function testLogout()
        {
            $user = new User();
            $user->id = "muchsin";
            $user->name = "Abdullah Muchsin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->user_id = $user->id;

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $this->sessionRepository->save($session);

            $this->userController->logout();

            $nameCookie = SessionService::$COOKIE_NAME;

            $this->expectOutputRegex("[Location: /]");
            $this->expectOutputRegex("[$nameCookie: ]");
        }
        public function testUpdateProfile()
        {
            $user = new User();
            $user->id = "muchsin";
            $user->name = "Abdullah Muchsin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->user_id = $user->id;

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $this->sessionRepository->save($session);

            $this->userController->updateProfile();

            $this->expectOutputRegex("[Update Profile]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Name]");
        }

        public function testUpdateProfileSuccess()
        {
            $user = new User();
            $user->id = "muchsin";
            $user->name = "Abdullah Muchsin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->user_id = $user->id;

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $this->sessionRepository->save($session);

            $_POST["name"] = "Budi";

            $this->userController->postUpdateProfile();

            $this->expectOutputRegex("[Location: /]");
        }

        public function testUpdateProfileValidationError()
        {
            $user = new User();
            $user->id = "muchsin";
            $user->name = "Abdullah Muchsin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->user_id = $user->id;

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $this->sessionRepository->save($session);

            $_POST["name"] = "";

            $this->userController->postUpdateProfile();

            $this->expectOutputRegex("[Id, and Password not blank]");
            $this->expectOutputRegex("[Update Profile]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Name]");
        }
    }
}
