<?php

namespace src\classes;
class Database
{
    public $mysqli;

    function __construct(string $hostname, string $username, string $password, string $database)
    {
        $this->mysqli = new mysqli($hostname, $username, $password, $database);;
    }
}

?>