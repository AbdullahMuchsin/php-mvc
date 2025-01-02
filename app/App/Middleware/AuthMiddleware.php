<?php

namespace AbdullahMuchsin\BelajarPhpMvc\App\Middleware;

class AuthMiddleware implements Middleware
{
    public function before(): void
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
    }
}
