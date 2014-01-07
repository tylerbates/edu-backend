<?php
namespace App\Model\Resource\Table;


class Order implements ITable
{
    public function getName()
    {
        return 'orders';
    }

    public function getPrimaryKey()
    {
        return 'order_id';
    }

    public function getSearchKey()
    {
        return 'order_id';
    }

} 