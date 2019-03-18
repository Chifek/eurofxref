<?php

namespace App\Tests;

use App\Entity\Eurofx;
use PHPUnit\Framework\TestCase;


class EurofxTest extends TestCase
{

    /**
     * @test
     * @description checked entities getters and setters
     */
    public function testSetGetEntity()
    {
        $var = new Eurofx();
        $var->setCharcode('CharCode');
        $var->setRate(0.13);

        $this->assertEquals($var->getCharcode(), 'CharCode');
        $this->assertEquals($var->getRate(), 0.13);
    }
}
