<?php
namespace Test\Model\Shipping;


use App\Model\Shipping\TableRate;
use App\Model\Address;

class TableRateTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsCode()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $table_rate = new TableRate($resource, new Address([]));
        $this->assertEquals('table_rate',$table_rate->getCode());
    }

    public function testReturnsLabel()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $table_rate = new TableRate($resource, new Address([]));
        $this->assertEquals('price depends on address',$table_rate->getLabel());
    }

    public function testReturnsPrice()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->once())
            ->method('find')
            ->with($this->equalTo(['city'=>'Rostov']))
            ->will($this->returnValue(['price'=>42]));

        $address = new Address(['city'=>'Rostov']);

        $table_rate = new TableRate($resource,$address);

        $this->assertEquals(42,$table_rate->getPrice());
    }
}
 