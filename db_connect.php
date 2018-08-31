<?php

class Connection {
    
    public static function getConnection() {
        static $db = null;
        if(is_null($db)) {
            try {
                $db = new PDO("mysql:host=localhost;dbname=??", "root", "");
            } catch (PDOExecption $e) {
                echo $e->getMessage();
            }
        }
        return $db;
    }
}