<?php
session_start();
if($_SERVER["REQUEST_METHOD"] === "POST") {

    require "db_connect.php";
    $db = Connection::getConnection();

    // intializ arr of errors
    $err = [];

    $data = [
        'name' =>  filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING),
        'credit' =>  filter_var(trim($_POST['credit']), FILTER_VALIDATE_FLOAT),
        'payment' =>  trim($_POST['payment']),
        'notif' =>  trim($_POST['notif'])
    ];

    if(!empty($data['payment'])) {
        $data['payment'] = filter_var($data['payment'], FILTER_VALIDATE_FLOAT);
    }

    //  validate data
    if(empty($data["name"])) {
        array_push($err, 'Nom incorrect ou vide!');
    } 
    if ($data['credit'] === false) {
        array_push($err, 'Credit incorrect ou vide!');
    }
    if ($data['payment'] === false) {
        array_push($err, 'Versement incorrect');
    }
    
    if(!empty($err)) {
        $_SESSION['errors'] = $err;
        header('Location: index.php');
        exit();
    } else {
        var_dump($data);
    }

} else {
    echo $_SERVER["REQUEST_METHOD"];

}

