<?php
require_once 'IResourceCollection.php';

class DBCollection implements IResourceCollection
{
    private $_connection;
    private $_table;

    public function __construct(PDO $connection, $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;
    }

    public function fetch()
    {
        return $this->_connection->query("SELECT * FROM {$this->_table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filter($column,$id)
    {
        return $result = $this->_connection->query("SELECT * FROM {$this->_table} WHERE " . $column . "=" . $id)
            ->fetchAll(PDO::FETCH_ASSOC);
        echo var_dump($result);
    }
}