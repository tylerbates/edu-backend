<?php
namespace Test\Model;

use App\Model\Customer;
use App\Model\ModelView;
use App\Model\Order;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testSetsParams()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $order = new Order(
            [],
            $resource,
            new \Zend\Mail\Transport\Smtp(),
            new Customer([],$resource),
            new \Zend\Mail\Message(),
            new ModelView('','','','',[])
        );
        $order->setCustomerId(1);
        $order->setShippingMethod('fixed');
        $order->setPaymentMethod('courier');
        $order->setAddress('ololo');
        $order->setItems('1,2,3');
        $order->setSubtotal(100);
        $order->setShipping(100);
        $order->setGrandTotal(200);

        $this->assertEquals(1,$order->getData('customer_id'));
        $this->assertEquals('fixed',$order->getData('shipping_method'));
        $this->assertEquals('courier',$order->getData('payment_method'));
        $this->assertEquals('ololo',$order->getData('address'));
        $this->assertEquals('1,2,3',$order->getData('items'));
        $this->assertEquals(100,$order->getData('subtotal'));
        $this->assertEquals(100,$order->getData('shipping'));
        $this->assertEquals(200,$order->getData('grand_total'));
    }
}
 