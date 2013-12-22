<?php
namespace App\Model\Resource\Table;

class QuoteItem implements ITable
{
    public function getName()
    {
        return 'quote_products';
    }

    public function getPrimaryKey()
    {
        return 'link_id';
    }

    public function getSearchKey()
    {
        return 'link_id';
    }
}