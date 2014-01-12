<?php
namespace App\Model;

use App\Model\Resource\IResourceCollection;

class ProductReviewCollection extends EntityCollection
{
    private $_prototype;

    public function __construct(IResourceCollection $resource, ProductReview $prototype)
    {
        $this->_prototype = $prototype;
        $this->_resource = $resource;
    }

    public function getProductReviews()
    {
        return array_map(
            function($data){
                $review = clone $this->_prototype;
                $review->setData($data);
                return $review;
            },$this->_resource->fetch());
    }


    public function filterByProduct(Product $product)
    {
        $this->_resource->filterBy('product_id', $product->getId());
    }

    public function getAverageRating()
    {
        $resource = clone $this->_resource;
        return $resource->average('rating');
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getProductReviews());
    }
}