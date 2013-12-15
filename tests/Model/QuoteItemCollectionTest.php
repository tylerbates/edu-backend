<?php
namespace Test\Model;
use App\Model\Product;
use App\Model\Quote;
use App\Model\QuoteItemCollection;

class QuoteItemCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @dataProvider getCustomerIds
    */
    public function testFiltersCollectionByQuote($customerId)
    {
        $cid = $customerId;
        $quote = new Quote(['customer_id' => $cid]);
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('filterBy')
            ->with($this->equalTo('customer_id'), $this->equalTo($cid));

        $collection = new QuoteItemCollection($resource);

        $collection->filterByQuote($quote);
    }

    public function getCustomerIds()
    {
        return 2;
    }

    public function testAssignsProducts()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['product_id' => 1]
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

        $qicollection = new QuoteItemCollection($resource);
        $qicollection->assignProducts(new Product([], $productResource),$productResource);
    }
}