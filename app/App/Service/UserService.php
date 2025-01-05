<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Service;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Exception\ValidationException;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserLoginRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserLoginRespone;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserRegisterRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserRegisterRespone;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use Exception;
use PDOException;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterRespone
    {
        try {
            Database::beginTransaction();
            $this->validateUserRegisterRequest($request);

            $user = $this->userRepository->findById($request->id);

            if ($user != null) {
                throw new ValidationException("User Id already exists");
            }

            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $respone = new UserRegisterRespone();
            $respone->user = $user;

            Database::commitTransaction();

            return $respone;
        } catch (Exception $exception) {
            Database::rollBackTransaction();
            throw $exception;
        }
    }

    public function validateUserRegisterRequest(UserRegisterRequest $request)
    {
        if (
            $request->id == null || $request->name == null || $request->password == null ||
            trim($request->id) == "" || trim($request->name) == "" || trim($request->password) == ""
        ) {
            throw new ValidationException("Id, Name, and Password not blank");
        }
    }

    public function login(UserLoginRequest $request): UserLoginRespone
    {
        $this->validateUserLoginRequest($request);

        $user = $this->userRepository->findById($request->id);

        if ($user == null) {
            throw new ValidationException("Id or Password is wrong");
        }

        if (password_verify($request->password, $user->password)) {

            $respone = new UserLoginRespone();
            $respone->user = $user;

            return $respone;
        } else {
            throw new ValidationException("Id or Password is wrong");
        }
    }

    public function validateUserLoginRequest(UserLoginRequest $request)
    {
        if (
            $request->id == null || $request->password == null ||
            trim($request->id) == "" || trim($request->password) == ""
        ) {
            throw new ValidationException("Id, and Password not blank");
        }
    }
}
