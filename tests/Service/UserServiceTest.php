<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Service;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Exception\ValidationException;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserLoginRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserRegisterRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserUpdatePasswordRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserUpdateProfileRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{

    private UserService $userService;
    private UserRepository $userRepository;

    public function setUp(): void
    {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);
        $sessionRepository = new SessionRepository($connection);

        $sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess()
    {

        $request = new UserRegisterRequest();
        $request->id = "muchsin";
        $request->name = "Abdullah Muchsin";
        $request->password = "rahasia";

        $respone = $this->userService->register($request);

        Assert::assertEquals($request->id, $respone->user->id);
        Assert::assertEquals($request->name, $respone->user->name);
        Assert::assertNotEquals($request->password, $respone->user->password);

        Assert::assertTrue(password_verify($request->password, $respone->user->password));
    }

    public function testRegisterFailed()
    {
        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "";
        $request->name = "";
        $request->password = "";

        $this->userService->register($request);
    }

    public function testRegisterDuplicate()
    {
        $user = new User();
        $user->id = "muchsin";
        $user->name = "Muchsin";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "muchsin";
        $request->name = "Abdullah Muchsin";
        $request->password = "rahasia";

        $this->userService->register($request);
    }

    public function testLoginSuccess()
    {

        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserLoginRequest();
        $request->id = "muchsin";
        $request->password = "rahasia";

        $respone = $this->userService->login($request);

        Assert::assertEquals($request->id, $respone->user->id);

        Assert::assertTrue(password_verify($request->password, $respone->user->password));
    }

    public function testLo()
    {
        $this->expectException(ValidationException::class);

        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest;
        $request->id = "muchsin";
        $request->oldPassword = "salah";
        $request->newPassword = "muchsin";

        $this->userService->updatePassword($request);
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->id = "muchsin";
        $request->password = "rahasia";

        $this->userService->login($request);
    }

    public function testLoginWrongPassword()
    {
        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserLoginRequest();
        $request->id = "muchsin";
        $request->password = "salah";

        $this->expectException(ValidationException::class);

        $this->userService->login($request);
    }

    public function testUpdateProfileSuccess()
    {
        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdateProfileRequest;
        $request->id = "muchsin";
        $request->name = "Muchsin";

        $this->userService->updateProfile($request);

        $result = $this->userRepository->findById($request->id);

        Assert::assertEquals($result->name, $request->name);
    }

    public function testUpdateProfileException()
    {
        $this->expectException(ValidationException::class);

        $request = new UserUpdateProfileRequest;
        $request->id = "muchsin";
        $request->name = "Muchsin";

        $this->userService->updateProfile($request);
    }

    public function testUpdateProf()
    {
        $this->expectException(ValidationException::class);

        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest;
        $request->id = "muchsin";
        $request->oldPassword = "salah";
        $request->newPassword = "muchsin";

        $this->userService->updatePassword($request);
        $this->expectException(ValidationException::class);

        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdateProfileRequest;
        $request->id = "andi";
        $request->name = "Muchsin";

        $this->userService->updateProfile($request);
    }

    public function testUpdatePasswordSuccess()
    {
        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest;
        $request->id = "muchsin";
        $request->oldPassword = "rahasia";
        $request->newPassword = "muchsin";

        $this->userService->updatePassword($request);

        $user = $this->userRepository->findById($request->id);

        $this->assertTrue(password_verify($request->newPassword, $user->password));
    }

    public function testUpdatePasswordValidationError()
    {
        $this->expectException(ValidationException::class);

        $request = new UserUpdatePasswordRequest;
        $request->id = "muchsin";
        $request->oldPassword = "";
        $request->newPassword = "";

        $this->userService->updatePassword($request);
    }

    public function testUpdatePasswordOldPasswordWrong()
    {
        $this->expectException(ValidationException::class);

        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest;
        $request->id = "muchsin";
        $request->oldPassword = "salah";
        $request->newPassword = "muchsin";

        $this->userService->updatePassword($request);
    }

    public function testUpdatePasswordNotFound()
    {
        $this->expectException(ValidationException::class);

        $user = new User();
        $user->id = "muchsin";
        $user->name = "Abdullah Muchsin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest;
        $request->id = "muchsin-kun";
        $request->oldPassword = "rahasia";
        $request->newPassword = "muchsin";

        $this->userService->updatePassword($request);
    }
}
