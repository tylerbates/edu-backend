<?php
namespace App\Model\Resource;

class DBConfig
{
    public static function connect()
    {
        return new \PDO('mysql:host=localhost;dbname=student','root','123qweasdzxc');
    }
}