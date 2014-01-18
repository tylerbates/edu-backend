<?php
namespace Test\Model\Quote;

use App\Model\Address;
use App\Model\Product;
use App\Model\Quote;
use App\Model\QuoteItem;
use App\Model\Shipping\Fixed;

class CollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollectsSubtotalFromQuote()
    {
        $collection = $this->getMockBuilder('App\Model\QuoteItemCollection')
            ->disableOriginalConstructor()
            ->getMock();
        $collection->expects($this->any())
            ->method('_getItems')
            ->will($this->returnValue([new QuoteItem(['price'=>10,'qty'=>3])]));
        $collection->expects($this->any())
            ->method('getItems')
            ->will($this->returnValue($collection));
        $collection->expects($this->any())
            ->method('assignProducts')
            ->will($this->returnValue([new Product(['price'=>10,'qty'=>3])]));

        $st_collector = new Quote\SubtotalCollector(new Product([]));

        $factory = $this->getMockBuilder('App\Model\Quote\CollectorsFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $factory->expects($this->any())
            ->method('getCollectors')
            ->will($this->returnValue(['subtotal'=>$st_collector]));

        $quote = new Quote([],null,$collection,null,$factory);

        $quote->collectTotals();
        $this->assertEquals(30,$quote->getSubtotal());
    }

    public function testCollectsShippingFromQuote()
    {
        $sh_factory = $this->getMockBuilder('App\Model\Shipping\Factory')
            ->disableOriginalConstructor()
            ->getMock();
        $sh_factory->expects($this->once())
            ->method('getMethods')
            ->will($this->returnValue([new Fixed()]));

        $sh_collector = new Quote\ShippingCollector($sh_factory);

        $factory = $this->getMockBuilder('App\Model\Quote\CollectorsFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $factory->expects($this->any())
            ->method('getCollectors')
            ->will($this->returnValue(['shipping'=>$sh_collector]));

        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('address_id'));

        $q_resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $q_resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('quote_id'));

        $quote = new Quote(['shipping_code'=>'fixed'],$q_resource,null,new Address([],$resource),$factory);

        $quote->collectTotals();
        $this->assertEquals(100,$quote->getShipping());
    }

    public function testCollectsGrandTotalFromQuote()
    {
        $gt_collector = new Quote\GrandTotalCollector();

        $factory = $factory = $this->getMockBuilder('App\Model\Quote\CollectorsFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $factory->expects($this->any())
            ->method('getCollectors')
            ->will($this->returnValue(['grand_total'=>$gt_collector]));

        $quote = new Quote(['subtotal'=>30,'shipping'=>100],null,null,null,$factory);
        $quote->collectTotals();
        $this->assertEquals(130,$quote->getGrandTotal());
    }
}