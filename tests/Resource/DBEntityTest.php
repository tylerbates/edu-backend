<?php
namespace Test\Model\Resource;

use App\Model\Resource\DBEntity;

class EntityCollectionTest extends \PHPUnit_Extensions_Database_TestCase
{
    public function testReturnsFoundDataFromDB()
    {
        $entity = $this->_getResource();

        $this->assertEquals(['id'=>1,'data'=>'foo'],$entity->find(['id'=>1]));
        $this->assertEquals(['id'=>2,'data'=>'bar'],$entity->find(['data'=>'bar']));
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

    public function testEscapesFilterParameter()
    {
        $resource = $this->_getResource();
        $this->assertEquals(['id' => 2, 'data' => 'bar'], $resource->find(['id'=>'2 - 1']));
    }

    public function testSavesDataInDB()
    {
        $resource= $this->_getResource();

        $resource->save(['id' => 3, 'data' => 'baz']);

        $queryTable = $this->getConnection()->createQueryTable(
            'abstract_collection', 'SELECT * FROM abstract_collection'
        );

        $expectedTable = (new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBEntityTest/expectations/testSavesDataInDb.yaml'
        ))->getTable('abstract_collection');

        $this->assertTablesEqual($expectedTable,$queryTable);
    }

    public function testUpdatesEntityIfExists()
    {
        $resource = $this->_getResource();

        $resource->save(['id' => 2, 'data' => 'baz']);

        $queryTable = $this->getConnection()->createQueryTable(
            'abstract_collection', 'SELECT * FROM abstract_collection'
        );

        $expectedTable = (new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBEntityTest/expectations/testUpdatesEntityIfExists.yaml'
        ))->getTable('abstract_collection');

        $this->assertTablesEqual($expectedTable,$queryTable);
    }

    public function testDeletesEntityFromDB()
    {
        $resource = $this->_getResource();
        $resource->delete(1);

        $queryTable = $this->getConnection()->createQueryTable(
            'abstract_collection', 'SELECT * FROM abstract_collection'
        );

        $expectedTable = (new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBEntityTest/expectations/testDeletesEntityFromDB.yaml'
        ))->getTable('abstract_collection');

        $this->assertTablesEqual($expectedTable,$queryTable);
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
        $table->expects($this->any())
            ->method('getSearchKey')
            ->will($this->returnValue('id'));
        return new DBEntity($this->getConnection()->getConnection(),$table);
    }
}