<?php

namespace App\Utilities;

class Database
{
    public function connect(): \PDO
    {
        $db = new \PDO('mysql:host=127.0.0.1;dbname=stock_api', 'root', 'password');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        return $db;
    }
}
