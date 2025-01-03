<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App;

class Reader
{
    public static function readerView($view, $model = []): void
    {
        require __DIR__ . '/../View' . $view . ".php";
    }
}
