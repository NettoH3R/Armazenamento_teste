<?php

    namespace src\MySQLConnection;
    
    class MySQLConnection extends \PDO{
        public function __construct(){
            parent::__construct('mysql:host="localhost;dbname=biblioteca','root','');
        }
    }
?>