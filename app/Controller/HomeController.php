<?php

namespace AbdullahMuchsin\BelajarPhpMvc\Controller;

use AbdullahMuchsin\BelajarPhpMvc\App\Reader;

class HomeController
{

    public function index(): void
    {

        $model = [
            'title' => 'About Me',
            'about' => 'My Name Abdullah Muchsin, i am live in jember city with parent',
        ];

        Reader::readerView("/home/index", $model);
    }

    public function about(string $nama, string $kota): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Mulai sesi jika belum dimulai
        }

        // Hancurkan sesi jika sudah ada
        session_destroy();
        echo "Nama : $nama, Kota : $kota";
    }
}
