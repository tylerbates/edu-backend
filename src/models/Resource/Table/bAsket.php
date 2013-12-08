<?php
namespace App\Model\Resource\Table;

class Basket implements ITable
{
    public function getName()
    {
        return 'baskets';
    }

    public function getPrimaryKey()
    {
        return 'basket_id';
    }

    public function getParams()
    {
        // TODO: Implement getParameter() method.
    }
}