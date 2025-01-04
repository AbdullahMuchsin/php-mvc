<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App;

class View
{
    public static function render($view, $model = []): void
    {
        require __DIR__ . '/../View/' . $view . ".php";
    }

    public static function redirect(string $url)
    {
        header("Location: " . $url);
    }
}
