<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Middleware\MustLoginMiddleware;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Middleware\MustNotLoginMiddleware;
use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\UserController;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Route;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\HomeController;

Database::getConnection("prod");

// Route Home Controller
Route::add('GET', '/', HomeController::class, 'index');

// Route User Controller
Route::add("GET", "/register", UserController::class, "register", [MustNotLoginMiddleware::class]);
Route::add("POST", "/register", UserController::class, "postRegister", [MustNotLoginMiddleware::class]);

Route::add("GET", "/login", UserController::class, "login", [MustNotLoginMiddleware::class]);
Route::add("POST", "/login", UserController::class, "postLogin", [MustNotLoginMiddleware::class]);

Route::add("GET", "/user/update", UserController::class, "updateProfile", [MustLoginMiddleware::class]);
Route::add("POST", "/user/update", UserController::class, "postUpdateProfile", [MustLoginMiddleware::class]);

Route::add("GET", "/logout", UserController::class, "logout", [MustLoginMiddleware::class]);

Route::run();
