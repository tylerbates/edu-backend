<?php
namespace App\Model\Resource\Table;

class QuoteItem implements ITable
{
    public function getName()
    {
        return 'customer_products';
    }

    public function getPrimaryKey()
    {
        return 'link_id';
    }

    public function getSearchKey()
    {
        return 'customer_id';
    }
}