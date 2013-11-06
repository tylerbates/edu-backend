<?php
require_once 'Review.php';
require_once 'Collection.php';

class ReviewCollection extends Collection
{
    public function getReviews()
    {
        return $this->getCollection();
    }

    public function getAverageRating()
    {
        $summary_rating = 0;

        foreach($this->getReviews() as $review)
        {
            $summary_rating += $review->getRating();
        }

        return $summary_rating/$this->getSize();
    }

    public function getReviewsByProduct($product_sku_reference)
    {
        $result = array();
        foreach($this->getReviews() as $review)
        {
            if($review->belongsToProduct($product_sku_reference)) $result[] = $review;
        }
        return $result;
    }
}