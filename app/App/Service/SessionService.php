<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Service;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\Session;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Domain\User;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\SessionRepository;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Repository\UserRepository;

class SessionService
{

    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public static string $COOKIE_NAME = "X-ABD-SESSION";

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(string $userId): Session
    {

        $session = new Session();
        $session->id = uniqid();
        $session->user_id = $userId;

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->id, time() + (60 * 60 * 24 * 30), "/");

        return $session;
    }

    public function destroy()
    {
        $id = $_COOKIE[self::$COOKIE_NAME] ?? "";

        $this->sessionRepository->deleteById($id);

        setcookie(self::$COOKIE_NAME, "", 1);
    }

    public function current(): ?User
    {
        $id = $_COOKIE[self::$COOKIE_NAME] ?? "";

        $session = $this->sessionRepository->findById($id);

        if ($session == null) {
            return null;
        }

        return $this->userRepository->findById($session->user_id);
    }
}
