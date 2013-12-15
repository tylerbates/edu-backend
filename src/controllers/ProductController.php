<?php
namespace App\Controller;

use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\Review as ReviewTable;

class ProductController extends Controller
{
    public function listAction()
    {
        $resource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\Product()]);
        $paginator = $this->_di->get('Paginator', ['collection' => $resource]);
        $paginator
            ->setItemCountPerPage(2)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();
        $_products = $this->_di->get('ProductCollection', ['resource' => $resource]);
        $products = $_products->getProducts();

        return $this->_di->get('View',[
            'template'=>'product_list',
            'params'=>['products'=>$products, 'pages'=>$pages]
        ]);
    }

    public function viewAction()
    {
        $resource = $this->_di->get('ResourceEntity', ['table' => new ProductTable()]);
        $product = $this->_di->get('Product',['resource' => $resource,'data'=>[]]);
        $product->load($_GET['id'],(new ProductTable())->getPrimaryKey());

        $resource = $this->_di->get('ResourceCollection',['table' => new ReviewTable()]);

        $reviews = $this->_di->get('ReviewCollection', ['resource' => $resource]);
        $reviews->filterByProduct($product);
        $_reviews = $reviews->getProductReviews();
        $average_rating = $reviews->getAverageRating();

        return $this->_di->get('View',[
            'template'=>'product_view',
            'params'=>['product'=>$product, 'rating'=>$average_rating, 'reviews'=>$_reviews]
        ]);
    }
}