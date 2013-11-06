<?php
require_once __DIR__ . '/../src/ReviewCollection.php';

class ReviewCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsReviewsWhichHaveBeenInitialized()
    {
        $reviews = new ReviewCollection([new Review(['name'=>'Nikolas']),new Review(['name'=>'Lilliana'])]);
        $this->assertEquals([new Review(['name'=>'Nikolas']),new Review(['name'=>'Lilliana'])],$reviews->getReviews());

        $reviews = new ReviewCollection([new Review(['name'=>'Lilliana']),new Review(['name'=>'Nikolas'])]);
        $this->assertEquals([new Review(['name'=>'Lilliana']),new Review(['name'=>'Nikolas'])],$reviews->getReviews());
    }

    public function testCalculatesCollectionSizeAsReviewsCount()
    {
        $reviews = new ReviewCollection([new Review([]),new Review([])]);
        $this->assertEquals(2,$reviews->getSize());

        $reviews = new ReviewCollection([new Review([])]);
        $this->assertEquals(1,$reviews->getSize());
    }

    public function testAppliesLimitToReviewCollectionSize()
    {
        $reviews = new ReviewCollection([new Review(['name'=>'Nikolas']),new Review(['name'=>'Lilliana'])]);

        $reviews->limit(1);
        $this->assertEquals(1,$reviews->getSize());

        $reviews->limit(3);
        $this->assertEquals(2,$reviews->getSize());

        $reviews->limit(0);
        $this->assertEquals(0,$reviews->getSize());
    }

    public function testAppliesLimitToCollectionReviews()
    {
        $reviews = new ReviewCollection([new Review(['name'=>'Lilliana']),new Review(['name'=>'Nikolas']),new Review(['name'=>'Dimacik'])]);

        $reviews->limit(1);
        $this->assertEquals([new Review(['name'=>'Lilliana'])],$reviews->getReviews());

        $reviews->limit(4);
        $this->assertEquals([new Review(['name'=>'Lilliana']),new Review(['name'=>'Nikolas']),new Review(['name'=>'Dimacik'])],$reviews->getReviews());

        $reviews->limit(0);
        $this->assertEquals([],$reviews->getReviews());
    }

    public function testAppliesOffsetToCollectionReviews()
    {
        $reviews = new ReviewCollection([new Review(['name'=>'Lilliana']),new Review(['name'=>'Nikolas']),new Review(['name'=>'Dimacik'])]);

        $reviews->offset(1);
        $this->assertEquals([new Review(['name'=>'Nikolas']),new Review(['name'=>'Dimacik'])],$reviews->getReviews());

        $reviews->offset(4);
        $this->assertEquals([],$reviews->getReviews());

        $reviews->offset(0);
        $this->assertEquals([new Review(['name'=>'Lilliana']),new Review(['name'=>'Nikolas']),new Review(['name'=>'Dimacik'])],$reviews->getReviews());
    }

    public function testAppliesOffsetToCollectionSize()
    {
        $reviews = new ReviewCollection([new Review(['name'=>'Lilliana']),new Review(['name'=>'Nikolas']),new Review(['name'=>'Dimacik'])]);

        $reviews->offset(1);
        $this->assertEquals(2,$reviews->getSize());

        $reviews->offset(4);
        $this->assertEquals(0,$reviews->getSize());
    }

    public function testAppliesLimitAndOffsetToCollectionReviews()
    {
        $reviews = new ReviewCollection([new Review(['name'=>'Lilliana']),new Review(['name'=>'Nikolas']),new Review(['name'=>'Dimacik'])]);

        $reviews->limit(1);
        $reviews->offset(1);
        $this->assertEquals([new Review(['name'=>'Nikolas'])],$reviews->getReviews());
    }

    public function testCalculatesAverageCollectionRating()
    {
        $reviews = new ReviewCollection([new Review(['rating'=>1]),new Review(['rating'=>2]),new Review(['rating'=>3])]);
        $this->assertEquals(2,$reviews->getAverageRating());

        $reviews = new ReviewCollection([new Review(['rating'=>1]),new Review(['rating'=>2]),new Review(['rating'=>3]),new Review(['rating'=>4])]);
        $this->assertEquals(2.5,$reviews->getAverageRating());
    }

    public function testReturnsReviewsWhichBelongToConcreteProduct()
    {
        $reviews = new ReviewCollection([new Review(['name'=>'Lilliana','rating'=>1,'product_sku_reference'=>'12345']),new Review(['name'=>'Nikolas','rating'=>2,'product_sku_reference'=>'12345']),new Review(['name'=>'Dimacik','rating'=>3])]);
        $this->assertEquals([new Review(['name'=>'Lilliana','rating'=>1,'product_sku_reference'=>'12345']),new Review(['name'=>'Nikolas','rating'=>2,'product_sku_reference'=>'12345'])],$reviews->getReviewsByProduct('12345'));

        $reviews = new ReviewCollection([]);
        $this->assertEquals([],$reviews->getReviewsByProduct('12345'));
    }

    public function testReturnsReviewsSortedByField()
    {
        $reviews = new ReviewCollection([new Review(['rating'=>3]),new Review(['rating'=>2]),new Review(['rating'=>1])]);
        $reviews->sort('rating');
        $this->assertEquals([new Review(['rating'=>1]),new Review(['rating'=>2]),new Review(['rating'=>3])],$reviews->getReviews());

        $reviews = new ReviewCollection([new Review(['name'=>'Lilliana','rating'=>1,'product_sku_reference'=>'12345']),new Review(['name'=>'Nikolas','rating'=>2,'product_sku_reference'=>'12345']),new Review(['name'=>'Dimacik','rating'=>3])]);
        $reviews->sort('name');
        $this->assertEquals([new Review(['name'=>'Dimacik','rating'=>3]),new Review(['name'=>'Lilliana','rating'=>1,'product_sku_reference'=>'12345']),new Review(['name'=>'Nikolas','rating'=>2,'product_sku_reference'=>'12345'])],$reviews->getReviews());
    }
}