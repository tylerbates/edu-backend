<?php
require_once 'ProductReview.php';
require_once 'EntityCollection.php';

class ProductReviewCollection extends Collection
{
    private $_productFilter;

    public function getProductReviews()
    {
        $reviews = $this->_getEntities();
        return $this->_applyProductFilter($reviews);
    }

    public function getAverageRating()
    {
        $ratings = array_map(function (ProductReview $review){
                return $review->getRating();
            },$this->getProductReviews());
        return array_sum($ratings)/count($ratings);
    }

    public function filterByProduct(Product $product)
    {
        $this->_productFilter = $product;
    }

    private function _applyProductFilter(array $reviews)
    {
        if(!$this->_productFilter) return $reviews;

        return array_filter($reviews,
            function(ProductReview $review)
            {
                return $review->belongsToProduct($this->_productFilter);
            }
        );
    }
}