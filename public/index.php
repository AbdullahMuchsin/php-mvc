<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Route;
use AbdullahMuchsin\BelajarPhpLoginManagement\Controller\HomeController;
use AbdullahMuchsin\BelajarPhpLoginManagement\App\Middleware\AuthMiddleware;

Route::add('GET', '/', HomeController::class, 'index');

Route::run();