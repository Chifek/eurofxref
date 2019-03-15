<?php

namespace App\Tests;

use App\Entity\Cbr;
use App\Controller\CbrController;
use PHPUnit\Framework\TestCase;


class EurofxTest extends TestCase
{

    /**
     * @test
     * @description checked entities getters and setters
     */
    public function testSetGetEntity()
    {
        $var = new Cbr();
        $var->setCharcode('CharCode');
        $var->setNumcode('Test');
        $var->setNominal(3);
        $var->setName('Test');
        $var->setValue(0.13);

        $this->assertEquals($var->getCharcode(), 'CharCode');
        $this->assertEquals($var->getNumcode(), 'Test');
        $this->assertEquals($var->getNominal(), 3);
        $this->assertEquals($var->getName(), 'Test');
        $this->assertEquals($var->getValue(), 0.13);
    }
}
