<?php

namespace App\Tests;

use App\Entity\Cbr;
use PHPUnit\Framework\TestCase;

class CbrTest extends TestCase
{
    public function testEntity()
    {
        $usd = new Cbr();
        $usd ->setCharcode('Test');

        $this->assertEquals($usd->getCharcode(), 'Test');
    }
}
