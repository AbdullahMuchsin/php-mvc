<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\UserController;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Route;
use AbdullahMuchsin\BelajarPhpLoginManagement\Config\Database;
use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\HomeController;

Database::getConnection("prod");

// Route Home
Route::add('GET', '/', HomeController::class, 'index');

// Route User Register
Route::add("GET", "/register", UserController::class, "register");
Route::add("POST", "/register", UserController::class, "postRegister");

Route::run();
