<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\Config;

use PDO;

class Database
{

    private static ?PDO $pdo = null;

    public static function  getConnection(string $env = "test"): PDO
    {

        if (self::$pdo == null) {

            require_once __DIR__ . "/../../config/database.php";

            $config = getConfigDatabase();

            self::$pdo = new PDO(
                $config["database"][$env]["url"],
                $config["database"][$env]["username"],
                $config["database"][$env]["password"]
            );
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }
}
