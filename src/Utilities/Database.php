<?php


namespace App\Utilities;


class Database
{
    static public function connect()
    {
        return new \PDO('mysql:host=127.0.0.1;dbname=stock_api', 'root', 'password');
    }
}
