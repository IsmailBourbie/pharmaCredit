<?php
session_start();
if($_SERVER["REQUEST_METHOD"] === "POST") {

    require "db_connect.php";
    $db = Connection::getConnection();

    // intializ arr of errors
    $err = [];

    $data = [
        'name' =>  htmlentities(strtolower(trim($_POST['name']))),
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

    // search about the name
    $sql = 'SELECT * FROM clients WHERE nom = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($data['name']));
    $result = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count == 0) {
        array_push($err, 'Le Nom ne existe pas');
    }
    if ($data['credit'] === false) {
        array_push($err, 'Credit incorrect ou vide!');
    }
    if ($data['payment'] === false) {
        array_push($err, 'Versement incorrect');
    }
    
    if(!empty($err)) {
        $_SESSION['errors_add_credit'] = $err;
        header('Location: index.php');
        exit();
    } else {
        $sql = "UPDATE clients SET credit_amount = credit_amount + :credit ,
                                   payroll_amount = payroll_amount + :payment 
                                WHERE nom = :name;
                INSERT INTO tracing VALUES(NULL, :name, :credit, :payment, :notif, CURRENT_TIMESTAMP)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':payment', floatval($data['payment']), PDO::PARAM_STR);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':credit', floatval($data['credit']), PDO::PARAM_STR);
        $stmt->bindValue(':notif', $data['notif'], PDO::PARAM_STR);
        if ($stmt->execute()){
            $_SESSION['success'] = 'Crédit ajouter';
            header('Location: index.php');
        };
    }

} else {
    echo $_SERVER["REQUEST_METHOD"];

}
