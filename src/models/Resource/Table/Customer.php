<?php
namespace App\Model\Resource\Table;

class Customer implements ITable
{
    public function getName()
    {
        return 'customers';
    }

    public function getPrimaryKey()
    {
        return 'customer_id';
    }

    public function getSearchKey()
    {
        return 'customer_id';
    }
}