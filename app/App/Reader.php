<?php

namespace AbdullahMuchsin\BelajarPhpMvc\App;

class Reader
{
    public static function readerView($view, $model): void
    {
        require __DIR__ . '/../View' . $view . ".php";
    }
}
