<?php
require_once __DIR__ . '/../src/models/ProductReviewCollection.php';
require_once __DIR__ . '/../src/models/Resource/IResourceCollection.php';

class ProductReviewCollectionResourcesTest extends PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('IResourceCollection');

        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name'=>'Nokla']
                ]
            ));

        $collection = new ProductReviewCollection($resource);
        $reviews = $collection->getProductReviews();
        $this->assertEquals('Nokla',$reviews[0]->getName());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['text' => 'foo'],
                    ['text' => 'bar']
                ]
            ));

        $collection = new ProductReviewCollection($resource);
        $reviews = $collection->getProductReviews();
        $expected = array(0 => 'foo', 1 => 'bar');
        $iterated = false;
        foreach ($reviews as $_key => $_review) {
            $this->assertEquals($expected[$_key], $_review->getText());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

    public function testFiltersDataByProduct()
    {
        $resource = $this->getMock('IResourceCollection');

        $resource->expects($this->any())
            ->method('filter')
            ->with($this->equalTo('product_id'),$this->equalTo(1))
            ->will($this->returnValue(
                [
                    ['product_id' => 1,'name'=>'asd']
                ]
            ));
        $collection = new ProductReviewCollection($resource);
        $reviews = $collection->filterByProduct($resource,'product_id',1);
        //echo var_dump($reviews);
        $this->assertEquals('asd',$reviews[0]->getName());

        $resource = $this->getMock('IResourceCollection');

        $resource->expects($this->any())
            ->method('filter')
            ->with($this->equalTo('product_id'),$this->equalTo(2))
            ->will($this->returnValue(
                [
                    ['product_id' => 2,'name'=>'dsa']
                ]
            ));

        $collection = new ProductReviewCollection($resource);
        $reviews = $collection->filterByProduct($resource,'product_id',2);
        $this->assertEquals('dsa',$reviews[0]->getName());
    }
}