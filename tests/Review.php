<?php
require_once __DIR__ . '/../src/Review.php';

class ReviewTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsNameWhichHasBeenInitialized()
    {
        $review = new Review(['name'=>'Nikolas']);
        $this->assertEquals('Nikolas',$review->getName());

        $review = new Review(['name'=>'Lilliana']);
        $this->assertEquals('Lilliana',$review->getName());
    }

    public function testReturnsEmailWhichHasBeenInitialized()
    {
        $review = new Review(['email'=>'Nikolas_123@gmail.com']);
        $this->assertEquals('Nikolas_123@gmail.com',$review->getEmail());

        $review = new Review(['email'=>'Lilliana1346@mail.ru']);
        $this->assertEquals('Lilliana1346@mail.ru',$review->getEmail());
    }

    public function testReturnsTextWhichHasBeenInitialized()
    {
        $review = new Review(['text'=>'qweasdzxcrtyfghvbn']);
        $this->assertEquals('qweasdzxcrtyfghvbn',$review->getText());

        $review = new Review(['text'=>'hbv4rc4rb4tn4tn4rtb']);
        $this->assertEquals('hbv4rc4rb4tn4tn4rtb',$review->getText());
    }

    public function testReturnsRatingWhichHasBeenInitialized()
    {
        $review = new Review(['rating'=>5]);
        $this->assertEquals(5,$review->getRating());

        $review = new Review(['rating'=>1]);
        $this->assertEquals(1,$review->getRating());
    }

    public function testReviewBelongsToConcreteProduct()
    {
        $review = new Review(['product_sku_reference'=>'12345']);
        $this->assertTrue($review->belongsToProduct('12345'));

        $review = new Review([]);
        $this->assertFalse($review->belongsToProduct('32680'));
    }
}