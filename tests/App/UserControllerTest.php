<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App {

    function header(string $value)
    {
        echo $value;
    }
}

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App {

    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
    use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
    use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\UserController;
    use PHPUnit\Framework\TestCase;

    class UserControllerTest extends TestCase
    {
        private UserRepository $userRepository;
        private UserController $userController;

        public function setUp(): void
        {
            $this->userController = new UserController();
            $this->userRepository = new UserRepository(Database::getConnection());

            $this->userRepository->deleteAll();
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
    }
}
