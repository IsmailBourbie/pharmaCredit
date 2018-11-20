<?php
require 'db_connect.php';
$db = Connection::getConnection();

if (isset($_POST['payroll_amount']) && isset($_POST['name'])) {
	$response['status'] = 200;
	$name = strtolower(trim($_POST['name']));
	$payroll_amount = filter_var(trim($_POST['payroll_amount']), FILTER_VALIDATE_FLOAT);
	if (empty($name) || $payroll_amount === false) {
		$response['status'] = 400;
	} else {

		// get the Credit of 
		$stmt_get = $db->prepare('SELECT credit_amount, payroll_amount FROM clients WHERE nom = :name');
		$stmt_get->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt_get->execute();
		$row = $stmt_get->fetch(PDO::FETCH_OBJ);
		$credit_val = (float) $row->credit_amount;
		$payroll_val = ((float) $row->payroll_amount);
		// if the rest is negative so turn it 0
		if(($credit_val - ($payroll_val + $payroll_amount)) < 0) {
			$payroll_amount = $credit_val - $payroll_val;
		}
		
		$stmt = $db->prepare('UPDATE clients SET payroll_amount = payroll_amount + :pay 
												WHERE nom = :name;
								INSERT INTO tracing (id, nom, payroll_amount, `current_date`)
								VALUES(NULL, :name, :pay, CURRENT_TIMESTAMP)');
		$stmt->bindValue(':pay', $payroll_amount, PDO::PARAM_STR);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		if ($stmt->execute() === false) {
			$response['status'] = 400;
		}
	}
	echo json_encode($response);
	return;
} elseif (isset($_POST['new_credit'])) {
	session_start();
	$_SESSION['name'] = trim($_POST['name']);
	$response = [
		'status' => 200,
		'go_to' => 'index.php'
	];
	echo json_encode($response);
} elseif (isset($_POST['name'])) {
	$response['status'] = 200;
	$name = trim($_POST['name']);
	if (empty($name)) {
		$response['status'] = 400;
	} else {
		$stmt = $db->prepare('SELECT credit_amount, payroll_amount, `current_date`, notification FROM tracing WHERE nom = :name');
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_NUM);
		$count = $stmt->rowCount();
		if ($count === 0) {
			$response['status'] = 400;
		} else {
			$response['data'] = $result;
		}
	}
	echo json_encode($response);
	return;
}