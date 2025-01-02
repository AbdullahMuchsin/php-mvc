<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\Config;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{

    public function testGetConnection()
    {
        $connection = Database::getConnection();

        Assert::assertNotNull($connection);
    }

    public function testGetConnectionSingleTon()
    {
        $connection1 = Database::getConnection();
        $connection2 = Database::getConnection();

        Assert::assertSame($connection1, $connection2);
    }
}
