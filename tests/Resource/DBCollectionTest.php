<?php
require_once __DIR__ . '/../../src/models/Resource/DBCollection.php';
require_once __DIR__ . '/../../src/models/Resource/IResourceCollection.php';

class DBCollectionTest extends PHPUnit_Extensions_Database_TestCase
{
    public function testFetchesDataFromDB()
    {
        $collection = new DBCollection($this->getConnection()->getConnection(),'abstract_collection');
        $this->assertEquals([
            ['id'=>1,'data'=>'foo'],
            ['id'=>2,'data'=>'bar']
        ],$collection->fetch());
    }

    public function testFiltersDataFromDB()
    {
        $collection = new DBCollection($this->getConnection()->getConnection(),'abstract_collection');
        $this->assertEquals(['id'=>1,'data'=>'foo'],$collection->filter('data','foo'));
    }

    public function getConnection()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=student_unit','root','123qweasdzxc');
        return $this->createDefaultDBConnection($pdo,'student_unit');
    }

    public function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBCollectionTest/fixtures/abstract_collection.yaml'
        );
    }
}