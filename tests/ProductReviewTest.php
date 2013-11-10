<?php
require_once __DIR__ . '/../src//models/ProductReview.php';

class ReviewTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsNameWhichHasBeenInitialized()
    {
        $review = new ProductReview(['name'=>'Nikolas']);
        $this->assertEquals('Nikolas',$review->getName());

        $review = new ProductReview(['name'=>'Lilliana']);
        $this->assertEquals('Lilliana',$review->getName());
    }

    public function testReturnsEmailWhichHasBeenInitialized()
    {
        $review = new ProductReview(['email'=>'Nikolas_123@gmail.com']);
        $this->assertEquals('Nikolas_123@gmail.com',$review->getEmail());

        $review = new ProductReview(['email'=>'Lilliana1346@mail.ru']);
        $this->assertEquals('Lilliana1346@mail.ru',$review->getEmail());
    }

    public function testReturnsTextWhichHasBeenInitialized()
    {
        $review = new ProductReview(['text'=>'qweasdzxcrtyfghvbn']);
        $this->assertEquals('qweasdzxcrtyfghvbn',$review->getText());

        $review = new ProductReview(['text'=>'hbv4rc4rb4tn4tn4rtb']);
        $this->assertEquals('hbv4rc4rb4tn4tn4rtb',$review->getText());
    }

    public function testReturnsRatingWhichHasBeenInitialized()
    {
        $review = new ProductReview(['rating'=>5]);
        $this->assertEquals(5,$review->getRating());

        $review = new ProductReview(['rating'=>1]);
        $this->assertEquals(1,$review->getRating());
    }

    public function testReviewBelongsToConcreteProduct()
    {
        $productFoo = new Product(['sku' => 'foo']);
        $productBar = new Product(['sku' => 'bar']);

        $review = new ProductReview(['product' => $productFoo]);
        $this->assertTrue($review->belongsToProduct($productFoo));
        $this->assertFalse($review->belongsToProduct($productBar));
    }
}