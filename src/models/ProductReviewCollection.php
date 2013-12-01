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
            },$this->_resource->fetch());
    }

    public function filterByProduct(Product $product)
    {
        $this->_resource->filterBy('product_id', $product->getId());
    }

    public function getAverageRating()
    {
        return $this->_resource->average('rating');
    }
}