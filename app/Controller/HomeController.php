<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\Controller;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\View;

class HomeController
{

    public function index(): void
    {
        $model = [
            'title' => 'Login Management',
        ];

        View::render("header", $model);
        View::render("home/index");
        View::render("footer");
    }

}
