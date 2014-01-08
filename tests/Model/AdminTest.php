<?php
namespace Test;


use App\Model\Admin;

class AdminTest extends \PHPUnit_Framework_TestCase
{
    public function testSavesDataInDB()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['name' => 'Vasia']));
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('admin_id'));

        $admin = new Admin(['name' => 'Vasia'],$resource);

        $admin->save($resource);
    }

    public function testReturnsIdWhichHasBeenInitialized()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('admin_id'));

        $admin = new Admin(['admin_id' => 1],$resource);
        $this->assertEquals(1,$admin->getId());

        $admin = new Admin(['admin_id' => 2],$resource);
        $this->assertEquals(2,$admin->getId());
    }

    public function  testReturnsIdAfterSave()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');

        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['name' => 'Vasia']))
            ->will($this->returnValue(24));
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('admin_id'));

        $admin = new Admin(['name' => 'Vasia'],$resource);
        $admin->save($resource);

        $this->assertEquals(24,$admin->getId());
    }

    public function testLoggesInByLoginAndPassword()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->once())
            ->method('find')
            ->will($this->returnValue(['name'=>'Vasia', 'password'=>md5('123')]));

        $admin = new Admin([],$resource);
        $this->assertTrue($admin->logIn('Vasia','123'));
    }
}
 