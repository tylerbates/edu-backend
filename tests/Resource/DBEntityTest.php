<?php
namespace Test\Model\Resource;

use App\Model\Resource\DBEntity;

class EntityCollectionTest extends \PHPUnit_Extensions_Database_TestCase
{
    public function testReturnsFoundDataFromDB()
    {
        $entity = $this->_getResource();

        $this->assertEquals(['id'=>1,'data'=>'foo'],$entity->find(1));
        $this->assertEquals(['id'=>2,'data'=>'bar'],$entity->find(2));
    }

    public function getConnection()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=student_unit','root','123qweasdzxc');
        return $this->createDefaultDBConnection($pdo,'student_unit');
    }

    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBEntityTest/fixtures/abstract_entity.yaml'
        );
    }

    private function _getResource()
    {
        $table = $this->getMock('\App\Model\Resource\Table\ITable');
        $table->expects($this->any())
              ->method('getName')
              ->will($this->returnValue('abstract_collection'));
        $table->expects($this->any())
            ->method('getPrimaryKey')
            ->will($this->returnValue('id'));
        return new DBEntity($this->getConnection()->getConnection(),$table);
    }
}