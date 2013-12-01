<?php
require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ProductReviewCollection.php';
require_once __DIR__ . '/../models/ProductReview.php';
require_once __DIR__ . '/../models/Resource/DBCollection.php';
require_once __DIR__ . '/../models/Resource/DBEntity.php';
require_once __DIR__ . '/../models/Resource/DBconfig.php';

class ProductController
{
    private $_connection;

    function __construct()
    {
        $this->_connection = DBConfig::connect();
    }

    function __destruct()
    {
        unset($this->_connection);
    }

    public function listAction()
    {
        $resource = new DBCollection($this->_connection,'products');
        $_products = new ProductCollection($resource);
        $products = $_products->getProducts();
        require_once __DIR__ . '/../views/product_list.phtml';
    }

    public function viewAction()
    {
        $product = new Product([]);

        $resource = new DBEntity($this->_connection,'products','product_id');
        $product->load($resource,$_GET['id']);

        $resource = new DBCollection($this->_connection,'reviews');
        $reviews = new ProductReviewCollection($resource);
        $reviews->filterByProduct($product);
        $_reviews = $reviews->getProductReviews();
        $average_rating = $reviews->getAverageRating();

        require_once __DIR__ . '/../views/product_view.phtml';
    }
}