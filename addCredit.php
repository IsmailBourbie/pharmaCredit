<?php

if($_SERVER["REQUEST_METHOD"] === "post") {

    require "db_connect.php";
    $db = Connection::getConnection();
    
} else {

}

