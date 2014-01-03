<?php
namespace Test\Model;

use App\Model\QuoteItem;

class QuoteItemTest extends \PHPUnit_Framework_TestCase
{
    public function testAddsQty()
    {
        $quoteItem = new QuoteItem(['product_id'=>1]);
        $quoteItem->addQty(2);

        $this->assertEquals(2,$quoteItem->getQty());
    }

    public function testReturnsQtyWhichHasBeenInitialized()
    {
        $quoteItem = new QuoteItem(['product_id'=>1,'qty'=>4]);
        $this->assertEquals(4,$quoteItem->getQty());

        $quoteItem = new QuoteItem(['product_id'=>3,'qty'=>1]);
        $this->assertEquals(1,$quoteItem->getQty());
    }

    public function testSavesDataInDB()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['product_id'=>3,'qty'=>1]));
        $quoteItem = new QuoteItem(['product_id'=>3,'qty'=>1],$resource);

        $quoteItem->save($resource);
    }

    public function  testReturnsIdAfterSave()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['product_id'=>3,'qty'=>1]))
            ->will($this->returnValue(24));

        $quoteItem = new QuoteItem(['product_id'=>3,'qty'=>1],$resource);
        $quoteItem->save($resource);

        $this->assertEquals(24,$quoteItem->getId());
    }
}