<?php
require_once __DIR__ . '/../src/models/EntityCollection.php';
require_once __DIR__ . '/../src/models/ProductReviewCollection.php';

class ProductReviewCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsProductReviewsWhichHaveBeenInitialized()
    {
        $ProductReviews = new ProductReviewCollection([new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Lilliana'])]);
        $this->assertEquals([new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Lilliana'])],$ProductReviews->getProductReviews());

        $ProductReviews = new ProductReviewCollection([new ProductReview(['name'=>'Lilliana']),new ProductReview(['name'=>'Nikolas'])]);
        $this->assertEquals([new ProductReview(['name'=>'Lilliana']),new ProductReview(['name'=>'Nikolas'])],$ProductReviews->getProductReviews());
    }

    public function testCalculatesCollectionSizeAsProductReviewsCount()
    {
        $ProductReviews = new ProductReviewCollection([new ProductReview([]),new ProductReview([])]);
        $this->assertEquals(2,$ProductReviews->getSize());
        $ProductReviews = new ProductReviewCollection([new ProductReview([])]);
        $this->assertEquals(1,$ProductReviews->getSize());
    }

    public function testAppliesLimitToProductReviewCollectionSize()
    {
        $ProductReviews = new ProductReviewCollection([new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Lilliana'])]);

        $ProductReviews->limit(1);
        $this->assertEquals(1,$ProductReviews->getSize());

        $ProductReviews->limit(3);
        $this->assertEquals(2,$ProductReviews->getSize());

        $ProductReviews->limit(0);
        $this->assertEquals(0,$ProductReviews->getSize());
    }

    public function testAppliesLimitToCollectionProductReviews()
    {
        $ProductReviews = new ProductReviewCollection([new ProductReview(['name'=>'Lilliana']),new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Dimacik'])]);

        $ProductReviews->limit(1);
        $this->assertEquals([new ProductReview(['name'=>'Lilliana'])],$ProductReviews->getProductReviews());

        $ProductReviews->limit(4);
        $this->assertEquals([new ProductReview(['name'=>'Lilliana']),new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Dimacik'])],$ProductReviews->getProductReviews());

        $ProductReviews->limit(0);
        $this->assertEquals([],$ProductReviews->getProductReviews());
    }

    public function testAppliesOffsetToCollectionProductReviews()
    {
        $ProductReviews = new ProductReviewCollection([new ProductReview(['name'=>'Lilliana']),new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Dimacik'])]);

        $ProductReviews->offset(1);
        $this->assertEquals([new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Dimacik'])],$ProductReviews->getProductReviews());

        $ProductReviews->offset(4);
        $this->assertEquals([],$ProductReviews->getProductReviews());

        $ProductReviews->offset(0);
        $this->assertEquals([new ProductReview(['name'=>'Lilliana']),new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Dimacik'])],$ProductReviews->getProductReviews());
    }

    public function testAppliesOffsetToCollectionSize()
    {
        $ProductReviews = new ProductReviewCollection([new ProductReview(['name'=>'Lilliana']),new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Dimacik'])]);

        $ProductReviews->offset(1);
        $this->assertEquals(2,$ProductReviews->getSize());

        $ProductReviews->offset(4);
        $this->assertEquals(0,$ProductReviews->getSize());
    }

    public function testAppliesLimitAndOffsetToCollectionProductReviews()
    {
        $ProductReviews = new ProductReviewCollection([new ProductReview(['name'=>'Lilliana']),new ProductReview(['name'=>'Nikolas']),new ProductReview(['name'=>'Dimacik'])]);

        $ProductReviews->limit(1);
        $ProductReviews->offset(1);
        $this->assertEquals([new ProductReview(['name'=>'Nikolas'])],$ProductReviews->getProductReviews());
    }

    public function testCalculatesAverageCollectionRating()
    {
        $ProductReviews = new ProductReviewCollection([new ProductReview(['rating'=>1]),new ProductReview(['rating'=>2]),new ProductReview(['rating'=>3])]);
        $this->assertEquals(2,$ProductReviews->getAverageRating());

        $ProductReviews = new ProductReviewCollection([new ProductReview(['rating'=>1]),new ProductReview(['rating'=>2]),new ProductReview(['rating'=>3]),new ProductReview(['rating'=>4])]);
        $this->assertEquals(2.5,$ProductReviews->getAverageRating());
    }

    public function testReturnsProductReviewsWhichBelongToConcreteProduct()
    {
        $productFoo = new Product(['sku' => 'foo']);
        $productBar = new Product(['sku' => 'bar']);

        $collection = new ProductReviewCollection(
            [
                new ProductReview(['product' => $productFoo]),
                new ProductReview(['product' => $productFoo]),
                new ProductReview(['product' => $productBar]),
            ]
        );
        $collection->filterByProduct($productFoo);

        $this->assertEquals(
            [
                new ProductReview(['product' => $productFoo]),
                new ProductReview(['product' => $productFoo]),
            ],
            $collection->getProductReviews()
        );
    }

    public function testReturnsProductReviewsSortedByField()
    {
        $collection = new ProductReviewCollection(
            [
                new ProductReview(['text' => 'C']),
                new ProductReview(['text' => 'A']),
                new ProductReview(['text' => 'B'])
            ]
        );

        $collection->sort('text');
        $this->assertEquals(
            [
                new ProductReview(['text' => 'A']),
                new ProductReview(['text' => 'B']),
                new ProductReview(['text' => 'C']),
            ],
            $collection->getProductReviews()
        );
    }

    public function testIsIterableWithForeachFunction()
    {
        $collection = new ProductReviewCollection(
            [new ProductReview(['text' => 'foo']), new ProductReview(['text' => 'bar'])]
        );
        $expected = array(0 => 'foo', 1 => 'bar');
        $iterated = false;
        foreach ($collection as $_key => $_review) {
            $this->assertEquals($expected[$_key], $_review->getText());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }
}