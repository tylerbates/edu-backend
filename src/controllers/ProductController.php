<?php
namespace App\Controller;

use App\Model\Resource\Table\Product as ProductTable;

class ProductController extends Controller
{
    public function listAction()
    {
        $paginator = $this->_di->get('Paginator');
        $paginator
            ->setItemCountPerPage(2)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();
        $prototype = $this->_di->get('Product',['data'=>[]]);
        $products = $this->_di->get('ProductCollection',['prototype'=>$prototype]);

        return $this->_di->get('View',[
            'template'=>'product_list',
            'params'=>['products'=>$products, 'pages'=>$pages]
        ]);
    }

    public function viewAction()
    {
        $paginator = $this->_di->get('Paginator');
        $paginator
            ->setItemCountPerPage(1)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();
        $this->_di->get('Session')->generateToken();
        $product = $this->_di->get('Product',['data'=>[]]);
        $product->load($_GET['id'],(new ProductTable())->getPrimaryKey());

        $reviews = $this->_di->get('ReviewCollection');
        $reviews->filterByProduct($product);
        $_reviews = $reviews->getProductReviews();
        $average_rating = $reviews->getAverageRating();

        return $this->_di->get('View',[
            'template'=>'product_view',
            'params'=>[
                'product'=>$product,
                'rating'=>$average_rating,
                'reviews'=>$_reviews,
                'pages'=>$pages
            ]
        ]);
    }
}