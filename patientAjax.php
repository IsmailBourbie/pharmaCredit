<?php
require 'db_connect.php';
$db = Connection::getConnection();

if (isset($_POST['payroll_amount']) && isset($_POST['name'])) {
	$response = [
		"status" => 200,
	];
	$name = trim($_POST['name']);
	$payroll_amount = filter_var(trim($_POST['payroll_amount']), FILTER_VALIDATE_INT);
	if (empty($name) || $payroll_amount === false) {
		$response['status'] = 400;
	} else {
		$stmt = $db->prepare('UPDATE clients SET payroll_amount = payroll_amount + :pay WHERE nom = :name');
		$stmt->bindValue(':pay', $payroll_amount, PDO::PARAM_STR);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		if ($stmt->execute() === false) {
			$response['status'] = 400;
		}
		echo json_encode($response);
	}
	

	echo "payroll";
} elseif (isset($_POST['name'])) {
	echo "tracing";
}