<?php
namespace Test\Payment;

use App\Model\Address;
use App\Model\Payment\Courier;

class CourierTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsCode()
    {
        $courier = new Courier($this->_getParams()[0],$this->_getParams()[1]);
        $this->assertEquals('courier',$courier->getCode());
    }

    public function testReturnsLabel()
    {
        $courier = new Courier($this->_getParams()[0],$this->_getParams()[1]);
        $this->assertEquals('payment to courier',$courier->getLabel());
    }

    public function testReturnsMethodAvaliability()
    {
        $resource = $this->_getParams()[0];
        $resource->expects($this->once())
            ->method('find')
            ->with($this->equalTo(['city'=>'Rostov']))
            ->will($this->returnValue(['courier'=>null]));

        $address = new Address(['city'=>'Rostov']);

        $courier = new Courier($resource, $address);

        $this->assertFalse($courier->isAvaliable());
    }

    private function _getParams()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $address = $this->getMockBuilder('App\Model\Address')->disableOriginalConstructor()->getMock();
        return [$resource, $address];
    }
}
 