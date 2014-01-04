<?php
namespace Test\Payment;

use App\Model\Address;
use App\Model\Payment\CashOnDelivery;

class CashOnDeliveryTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsCode()
    {
        $cod = new CashOnDelivery($this->_getParams()[0],$this->_getParams()[1]);
        $this->assertEquals('cash_on_delivery', $cod->getCode());
    }

    public function testReturnsLabel()
    {
        $cod = new CashOnDelivery($this->_getParams()[0],$this->_getParams()[1]);
        $this->assertEquals('payment by cash on delivery', $cod->getLabel());
    }

    public function testReturnsMethodAvaliability()
    {
        $resource = $this->_getParams()[0];
        $resource->expects($this->once())
            ->method('find')
            ->with($this->equalTo(['city'=>'Rostov']))
            ->will($this->returnValue(['pbd'=>1]));

        $address = new Address(['city'=>'Rostov']);

        $cod = new CashOnDelivery($resource, $address);

        $this->assertTrue($cod->isAvaliable());
    }

    private function _getParams()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $address = $this->getMockBuilder('App\Model\Address')->disableOriginalConstructor()->getMock();
        return [$resource, $address];
    }
}
 