<?php
require_once __DIR__ . '/../../src/models/Resource/IResourceEntity.php';
require_once __DIR__ . '/../../src/models/Resource/DBEntity.php';

class EntityCollectionTest extends PHPUnit_Extensions_Database_TestCase
{
    public function getConnection()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=student_unit','root','123qweasdzxc');
        return $this->createDefaultDBConnection($pdo,'student_unit');
    }

    public function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBEntityTest/fixtures/abstract_entity.yaml'
        );
    }

    public function testReturnsFoundDataFromDB()
    {
        $entity = new DBEntity($this->getConnection()->getConnection(),'abstract_collection','id');

        $this->assertEquals(['id'=>1,'data'=>'foo'],$entity->find(1));
        $this->assertEquals(['id'=>2,'data'=>'bar'],$entity->find(2));
    }
}