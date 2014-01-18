<?php
namespace Test\Model;

use App\Model\ProductReview;
use App\Model\ProductReviewCollection;
use App\Model\Product;

class ProductReviewCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'Vasia']
                ]
            ));
        $prototype = new ProductReview([]);
        $collection = new ProductReviewCollection($resource,$prototype);

        $reviews = $collection->getProductReviews();
        $this->assertEquals('Vasia', $reviews[0]->getName());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'Vasia'],
                    ['name' => 'Petia']
                ]
            ));

        $prototype = new ProductReview([]);
        $collection = new ProductReviewCollection($resource,$prototype);
        $reviews = $collection->getProductReviews();
        $expected = array(0 => 'Vasia', 1 => 'Petia');
        $iterated = false;
        foreach ($reviews as $_key => $_productReview) {
            $this->assertEquals($expected[$_key], $_productReview->getName());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

    /**
     * @dataProvider getProductIds
     */
    public function testFiltersCollectionByProduct($productId)
    {
        $product = new Product(['product_id' => $productId]);
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('filterBy')
            ->with($this->equalTo('product_id'), $this->equalTo($productId));
        $prototype = new ProductReview([]);
        $collection = new ProductReviewCollection($resource,$prototype);

        $collection->filterByProduct($product);
    }

    public function getProductIds()
    {
        return [[1], [2]];
    }

    public function testCalculatesAverageRating()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('average')
            ->with($this->equalTo('rating'));
        $prototype = new ProductReview([]);
        $collection = new ProductReviewCollection($resource,$prototype);
        $collection->getAverageRating();
    }
}