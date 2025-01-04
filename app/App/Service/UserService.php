<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Service;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Exception\ValidationException;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserRegisterRequest;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Model\UserRegisterRespone;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
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

            if ($user) {
                throw new ValidationException("User Id already exists");
            }

            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->password = $request->password;

            $this->userRepository->save($user);

            $respone = new UserRegisterRespone();
            $respone->user = $user;

            Database::commitTransaction();

            return $respone;
        } catch (PDOException $exception) {
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
}
