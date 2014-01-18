<?php
namespace Test\Model\Shipping;

use App\Model\Shipping\Fixed;

class FixedTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsPrice()
    {
        $fixed = new Fixed();
        $this->assertEquals(100,$fixed->getPrice());
    }

    public function testReturnsCode()
    {
        $fixed = new Fixed();
        $this->assertEquals('fixed',$fixed->getCode());
    }

    public function testReturnsLabel()
    {
        $fixed = new Fixed();
        $this->assertEquals('fixed price: ',$fixed->getLabel());
    }
}