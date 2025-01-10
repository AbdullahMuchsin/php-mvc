<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{

    public function testRender()
    {

        View::render('header');
        View::render('home/index');
        View::render('footer');

        $this->expectOutputRegex("[Silakan pilih untuk Login atau Register]");
        $this->expectOutputRegex("[Pertanian Kita]");
        $this->expectOutputRegex("[Login]");
        $this->expectOutputRegex("[Register]");
    }
}
