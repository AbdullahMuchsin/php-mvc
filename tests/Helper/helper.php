<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App {

    function header(string $value)
    {
        echo "Location: $value";
    }
}

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Service {

    function setcookie(string $name, string $value)
    {
        echo "$name: $value";
    }
}
