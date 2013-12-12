<?php
namespace App\Model\Resource;

class DBEntity implements IResourceEntity
{
    private $_connection;
    private $_table;
    private $_primaryKey;

    public function getTable()
    {
        return $this->_table;
    }

    public function __construct(\PDO $connection, Table\ITable $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;
    }

    public function find($param)
    {
        $field = array_keys($param)[0];
        $stmt = $this->_connection->prepare(
            "SELECT * FROM {$this->_table->getName()} WHERE {$field} = :id"
        );
        $stmt->execute([':id' => $param[$field]]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function save($data)
    {
        $fields = array_keys($data);
        if($this->_itemExists($data))
        {
            $stmt = $this->_updateItem($fields);
        }
        else
        {
            $stmt = $this->_insertItem($fields);
        }
        $stmt->execute(array_combine($this->_prepareBinds($fields),$data));

        return $this->_connection->lastInsertId($this->_table->getPrimaryKey());
    }

    private function _itemExists($data)
    {
        $id = 0;
        if(isset($data[$this->_table->getPrimaryKey()]))
        {
            $id = $this->find([$this->_table->getPrimaryKey()=>$data[$this->_table->getPrimaryKey()]]);
        }
        return (bool) $id;
    }

    private function _prepareBinds($fields)
    {
        $binds = array_map(
            function ($field) {
                return ":{$field}";
            }, $fields);
        return $binds;
    }

    private function _insertItem($fields)
    {
        $filedList = implode(',', $fields);
        $bindList = implode(',', $this->_prepareBinds($fields));
        $stmt = $this->_connection->prepare(
            "INSERT INTO {$this->_table->getName()} ({$filedList}) VALUES ({$bindList})"
        );
        return $stmt;
    }

    private function _updateItem($fields)
    {
        $update= array_map(
            function ($field) {
                return "{$field} = :{$field}";
            }, $fields);

        $updateList = implode(',',$update);
        $condition = "{$this->_table->getPrimaryKey()} = :{$this->_table->getPrimaryKey()}";
        $stmt = $this->_connection->prepare(
            "UPDATE {$this->_table->getName()} SET {$updateList} WHERE {$condition}"
        );

        return $stmt;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->_table->getName()} WHERE {$this->_table->getPrimaryKey()} = :id";
        $stmt = $this->_connection->prepare($sql);
        $stmt->execute([':id'=>$id]);
    }
}