<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AbdullahMuchsin\BelajarPhpMvc\App\Route;
use AbdullahMuchsin\BelajarPhpMvc\Controller\HomeController;
use AbdullahMuchsin\BelajarPhpMvc\App\Middleware\AuthMiddleware;

Route::add('GET', '/', HomeController::class, 'index');
Route::add('GET', '/about/([0-9a-zA-Z]*)/kota/([0-9a-zA-Z]*)', HomeController::class, 'about');

Route::run();