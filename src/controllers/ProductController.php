<?php
require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ProductReviewCollection.php';

class ProductController
{
    public function listAction()
    {
        $products = new ProductCollection([
            new Product([
                'image'         => 'http://active-buy.com/foto/thumb-kopiya-nokia-6900-tv-2sim-fm-12-1mpx-kamera-mobilnye-telefony-597.jpg',
                'name'          => 'Nokla',
                'sku'           => '1233212312312312',
                'price'         => 100,
                'special_price' => 99.99,
            ]),
            new Product([
                'image'         => 'http://active-buy.com/foto/thumb-kopiya-nokia-6900-tv-2sim-fm-12-1mpx-kamera-mobilnye-telefony-597.jpg',
                'name'          => 'Nokla',
                'sku'           => '1233212312312312',
                'price'         => 100,
                'special_price' => 99.99,
            ]),
            new Product([
                'image'         => 'http://active-buy.com/foto/thumb-kopiya-nokia-6900-tv-2sim-fm-12-1mpx-kamera-mobilnye-telefony-597.jpg',
                'name'          => 'Nokla',
                'sku'           => '1233212312312312',
                'price'         => 100,
                'special_price' => 99.99,
            ]),
            new Product([
                'image'         => 'http://static.mobile-arsenal.com.ua/images/catalog/motorola/c650/motorola-c650_1-m.jpg',
                'name'          => 'Motorolka',
                'sku'           => '1233212312312312',
                'price'         => 50,
                'special_price' => 49.99,
            ]),
            new Product([
                'image'         => 'http://static.mobile-arsenal.com.ua/images/catalog/motorola/c650/motorola-c650_1-m.jpg',
                'name'          => 'Motorolka',
                'sku'           => '1233212312312312',
                'price'         => 50,
                'special_price' => 49.99,
            ])
        ]);

        require_once __DIR__ . '/../views/product_list.phtml';
    }

    public function viewAction()
    {
        $product = new Product([
            'image'         => 'http://active-buy.com/foto/thumb-kopiya-nokia-6900-tv-2sim-fm-12-1mpx-kamera-mobilnye-telefony-597.jpg',
            'name'          => 'Nokla',
            'sku'           => '1233212312312312',
            'price'         => 100,
            'special_price' => 99.99,
        ]);

        $reviews = new ProductReviewCollection([
            new ProductReview([
                'name'=>'Sasha',
                'email'=>'Sasha@gmail.com',
                'text'=>'safgcwrthwerxdwexhtctwrgwefcwehgwcerfhcwethfwerhderth rthwrthwr',
                'rating'=>5,
                'product'=>$product
            ]),
            new ProductReview([
                'name'=>'Sasha',
                'email'=>'Sasha@gmail.com',
                'text'=>'safgcwrthwerxdwexhtctwrgwefcwehgwcerfhcwethfwerhderth rthwrthwr',
                'rating'=>4,
                'product'=>'asfsadgasdg'
            ]),
            new ProductReview([
                'name'=>'Sasha',
                'email'=>'Sasha@gmail.com',
                'text'=>'safgcwrthwerxdwexhtctwrgwefcwehgwcerfhcwethfwerhderth rthwrthwr',
                'rating'=>3,
                'product'=>$product
            ]),
            new ProductReview([
                'name'=>'Sasha',
                'email'=>'Sasha@gmail.com',
                'text'=>'safgcwrthwerxdwexhtctwrgwefcwehgwcerfhcwethfwerhderth rthwrthwr',
                'rating'=>2,
                'product'=>'asasfassg'
            ])


        ]);
        $reviews->filterByProduct($product);
        $_reviews = $reviews->getProductReviews();
        require_once __DIR__ . '/../views/product_view.phtml';
    }
}