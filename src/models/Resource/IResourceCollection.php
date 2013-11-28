<?php
interface IResourceCollection
{
    public function fetch();

    public function filter($column, $id);

}