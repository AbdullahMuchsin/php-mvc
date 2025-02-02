<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Middleware {

    require_once __DIR__ . "/../Helper/helper.php";

    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\Session;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
    use AbdullahMuchsin\BelajarPhpLoginManagement\App\Service\SessionService;
    use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
    use PHPUnit\Framework\TestCase;

    class MustNotLoginMiddlewareTest extends TestCase
    {

        private SessionRepository $sessionRepository;
        private UserRepository $userRepository;
        private MustNotLoginMiddleware $mustNotLoginMiddleware;

        public function setUp(): void
        {
            $this->mustNotLoginMiddleware = new MustNotLoginMiddleware();
            $this->sessionRepository = new SessionRepository(Database::getConnection());
            $this->userRepository = new UserRepository(Database::getConnection());

            $this->sessionRepository->deleteAll();
            $this->userRepository->deleteAll();

            putenv("mode=test");
        }

        public function testBeforeGuest()
        {
            $this->mustNotLoginMiddleware->before();

            $this->expectOutputString("");
        }

        public function testBeforeLoginUser()
        {
            $user = new User;
            $user->id = "muchsin";
            $user->name = "Abdullah Muchsin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $sesion = new Session();
            $sesion->id = uniqid();
            $sesion->user_id = $user->id;

            $_COOKIE[SessionService::$COOKIE_NAME] = $sesion->id;

            $this->sessionRepository->save($sesion);

            $this->mustNotLoginMiddleware->before();

            $this->expectOutputRegex("[Location: /]");
        }
    }
}
