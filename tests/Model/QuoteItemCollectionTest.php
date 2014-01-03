<?php
namespace Test\Model;
use App\Model\Product;
use App\Model\Quote;
use App\Model\QuoteItem;
use App\Model\QuoteItemCollection;

class QuoteItemCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testFiltersCollectionByQuote()
    {
        $items = $this->getMock('App\Model\Resource\IResourceCollection');
        $items->expects($this->once())->method('filterBy')
            ->with($this->equalTo('quote_id'), $this->equalTo(42));
        $items->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue([]));

        $quote = $this->getMock('App\Model\Quote', ['getId']);
        $quote->expects($this->any())->method('getId')
            ->will($this->returnValue(42));



        $quoteItems = new QuoteItemCollection($items, new QuoteItem([]));
        $quoteItems->filterByQuote($quote);
    }

    public function testAssignsProducts()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['product_id' => 1,'qty'=>1, 'link_id'=>1]
                ]
            ));
        $productResource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('find')
            ->will($this->returnValue(
                [
                    ['name'=>'vasia']
                ]
            ));

        $qicollection = new QuoteItemCollection($resource, new QuoteItem([]));
        $qicollection->assignProducts(new Product([], $productResource),$productResource);
    }
}