<?php
namespace Test\Model;

use App\Model\Product;
use App\Model\Quote;
use App\Model\QuoteItem;
use App\Model\QuoteItemCollection;

class QuoteTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadsQuoteBySession()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
            ->method('find')
            ->will($this->returnValue(['quote_id'=>1,'customer_id'=>1]));

        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['getQuoteId'])
            ->getMock();
        $session->expects($this->any())
            ->method('getQuoteId')
            ->will($this->returnValue(1));

        $quote = new Quote([],$resource);
        $quote->loadBySession($session);

        $this->assertEquals(1,$quote->getData('quote_id'));
    }

    public function testLoadsQuoteByCustomer()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
            ->method('find')
            ->will($this->returnValue(['quote_id'=>1,'customer_id'=>1]));

        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['getUserId'])
            ->getMock();
        $session->expects($this->any())
            ->method('getUserId')
            ->will($this->returnValue(1));

        $quote = new Quote([],$resource);
        $quote->loadByCustomer($session);

        $this->assertEquals(1,$quote->getData('quote_id'));
    }

    public function testReturnsAssignedAddress()
    {
        $address = $this->getMockBuilder('App\Model\Address',['load'])
            ->disableOriginalConstructor()
            ->getMock();
        $address->expects($this->once())
            ->method('load')
            ->with($this->equalTo(42));

        $quote = new Quote(['address_id'=>42],null,null,$address);
        $this->assertSame($address,$quote->getAddress());
    }

    public function testCreatesNewAddressIfNotAssigned()
    {
        $address = $this->getMockBuilder('App\Model\Address',['getId','save'])
            ->disableOriginalConstructor()
            ->getMock();

        $address->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(42));
        $address->expects($this->once())
            ->method('save');

        $quoteResource = $this->getMock('App\Model\Resource\IResourceEntity');
        $quoteResource->expects($this->once())
            ->method('save')
            ->with($this->equalTo(['address_id'=>42]));

        $quote = new Quote([],$quoteResource,null,$address);

        $this->assertSame($address,$quote->getAddress());
    }

    public function testCollectsTotalsFromCollectors()
    {
        $collectors = [
            'subtotal'=>$this->_createTotal(42),
            'shipping'=>$this->_createTotal(24),
            'grand_total'=>$this->_createTotal(42+24)
        ];

        $totalsFactory = $this->getMockBuilder('App\Model\Quote\CollectorsFactory',['getCollectors'])
            ->disableOriginalConstructor()
            ->getMock();
        $totalsFactory->expects($this->once())
            ->method('getCollectors')
            ->will($this->returnValue($collectors));

        $quote = new Quote([],null,null,null,$totalsFactory);
        $quote->collectTotals();
        $this->assertEquals(42,$quote->getSubtotal());
        $this->assertEquals(24,$quote->getShipping());
        $this->assertEquals(42+24,$quote->getGrandTotal());
    }

    private function _createTotal($value)
    {
        $total = $this->getMock('App\Model\Quote\ICollector',['collect']);
        $total->expects($this->once())
            ->method('collect')
            ->will($this->returnValue($value));

        return $total;
    }
}
