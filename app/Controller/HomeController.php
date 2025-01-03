<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\Controller;

use AbdullahMuchsin\BelajarPhpLoginManagement\App\Reader;

class HomeController
{

    public function index(): void
    {
        $model = [
            'title' => 'Login Management',
        ];

        Reader::readerView("/header", $model);
        Reader::readerView("/home/index");
        Reader::readerView("/footer");
    }

}
