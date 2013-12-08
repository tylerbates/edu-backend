<?php
namespace App\Model\Resource\Table;

class BasketProducts implements ITable
{
    public function getName()
    {
        return 'basket_products';
    }

    public function getPrimaryKey()
    {
        return 'link_id';
    }

    public function getParams()
    {
        return ['product_id','basket_id'];
    }
}