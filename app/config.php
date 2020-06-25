<?php
namespace config;

class Dbconfig {
    protected $serverName;
    protected $userName;
    protected $passCode;
    protected $dbName;

    function __construct() {
        $this->serverName = 'mysql';
        $this->userName = 'dev';
        $this->passCode = 'dev';
        $this->dbName = 'database';
    }
}

?>