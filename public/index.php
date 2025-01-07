<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\UserController;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Route;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\HomeController;

Database::getConnection("prod");

// Route Home Controller
Route::add('GET', '/', HomeController::class, 'index');

// Route User Controller
Route::add("GET", "/register", UserController::class, "register");
Route::add("POST", "/register", UserController::class, "postRegister");

Route::add("GET", "/login", UserController::class, "login");
Route::add("POST", "/login", UserController::class, "postLogin");

Route::add("GET", "/logout", UserController::class, "logout");

Route::run();
