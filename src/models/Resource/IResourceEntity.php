<?php
namespace App\Model\Resource;

interface IResourceEntity
{
    public function find($id);

    public function save($data);

    public function delete($id);

    public function getTable();
}