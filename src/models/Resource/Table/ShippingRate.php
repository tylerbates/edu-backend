<?php
namespace App\Model\Resource\Table;

class ShippingRate implements ITable
{
    public function getName()
    {
        return 'shipping_rate';
    }

    public function getPrimaryKey()
    {
        return 'rate_id';
    }

    public function getSearchKey()
    {
        return 'city';
    }
}