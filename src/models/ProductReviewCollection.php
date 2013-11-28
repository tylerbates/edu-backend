<?php
require_once 'ProductReview.php';
require_once 'EntityCollection.php';

class ProductReviewCollection extends Collection
{
    public function getProductReviews()
    {
        return array_map(
            function($data){
                return new ProductReview($data);
            },$this->_getEntities());
    }

    public function getAverageRating()
    {
        $ratings = array_map(function (ProductReview $review){
                return $review->getRating();
            },$this->getProductReviews());
        return array_sum($ratings)/count($ratings);
    }

    public function filterByProduct(IResourceCollection $resource, $column ,$id)
    {
        return array_map(
            function($data){
                return new ProductReview($data);
            },$resource->filter($column,$id));
    }
}