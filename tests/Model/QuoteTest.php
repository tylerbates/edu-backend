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

        $quote = new Quote();
        $quote->loadByCustomer($resource,1);

        $this->assertEquals([new QuoteItem(['link_id'=>1,'customer_id'=>1,'product_id'=>1,'qty'=>3])],$quote->getProducts());
    }

    public function testLoadsQuoteBySession()
    {
        $resource = $this->getMock('App\Model\Session');
        $resource->expects($this->any())
                 ->method('getProducts')
                 ->will($this->returnValue([['product_id'=>1,'qty'=>2]]));

        $quote = new Quote();
        $quote->loadBySession($resource);

        $this->assertEquals([new QuoteItem(['product_id'=>1,'qty'=>2])],$quote->getProducts());
    }

    public function testReturnsQuoteItemForProduct()
    {
        $product = new Product(['product_id'=>1,'name'=>'foo']);
        $quote = new Quote();
        $quoteItem = $quote->getItemForProduct($product,1,2);

        $this->assertEquals(1,$quoteItem->getData('product_id'));
    }

}
