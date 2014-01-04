<?php
namespace Test\Payment;

use App\Model\Payment\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsPaymentMethodCollection()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $address = $this->getMockBuilder('App\Model\Address')->disableOriginalConstructor()->getMock();
        $collection = $this->getMock('\App\Model\Payment\Collection', ['addPayment']);
        $factory = new Factory($resource, $address, $collection);
        $collection->expects($this->at(0))
            ->method('addPayment')
            ->with($this->isInstanceOf('\App\Model\Payment\Courier'));
        $collection->expects($this->at(1))
            ->method('addPayment')
            ->with($this->isInstanceOf('\App\Model\Payment\CashOnDelivery'));
        $this->assertSame($collection, $factory->getMethods());
    }
}
 