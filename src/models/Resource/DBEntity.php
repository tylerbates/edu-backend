<?php
require_once 'IResourceEntity.php';

class DBEntity implements IResourceEntity
{
    private $_connection;
    private $_table;
    private $_primaryKey;

    public function __construct(PDO $connection, $table, $primary_key)
    {
        $this->_connection = $connection;
        $this->_table = $table;
        $this->_primaryKey = $primary_key;
    }

    public function find($id)
    {
        return $this->_connection
            ->query("SELECT * FROM {$this->_table} WHERE {$this->_primaryKey} = {$id}")
            ->fetch(PDO::FETCH_ASSOC);
    }
}