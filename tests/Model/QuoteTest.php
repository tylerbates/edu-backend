<?php
namespace Test\Model;

use App\Model\Product;
use App\Model\Quote;
use App\Model\QuoteItem;

class QuoteTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadsQuoteByCustomer()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
                 ->method('find')
                 ->will($this->returnValue([['link_id'=>1,'customer_id'=>1,'product_id'=>1,'qty'=>3]]));

        $quote = new Quote($resource);
        $quote->loadByCustomer(1);

        $this->assertEquals([new QuoteItem(['link_id'=>1,'customer_id'=>1,'product_id'=>1,'qty'=>3])],$quote->getProducts());
    }

    public function testLoadsQuoteBySession()
    {
        $entity_resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $entity_resource->expects($this->any())
            ->method('find')
            ->will($this->returnValue([['link_id'=>1,'customer_id'=>1,'product_id'=>1,'qty'=>3]]));

        $session_resource = $this->getMock('App\Model\Session');
        $session_resource->expects($this->any())
                 ->method('getQuote')
                 ->will($this->returnValue([[1]]));

        $quote = new Quote($entity_resource);
        $quote->loadBySession($session_resource);

        $this->assertEquals([new QuoteItem(['link_id'=>1,'customer_id'=>1,'product_id'=>1,'qty'=>3])],$quote->getProducts());
    }

    public function testReturnsQuoteItemForProduct()
    {
        $product = new Product(['product_id'=>1,'name'=>'foo']);
        $entity_resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $quote = new Quote($entity_resource);
        $quoteItem = $quote->getItemForProduct($product,1,2);

        $this->assertEquals(1,$quoteItem->getData('product_id'));
    }

}
