<?php session_start();
$_SESSION['title'] = "Patients";
include 'inc/head.php';

if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
	header('Location: index.php');
	exit();
}
require "db_connect.php";
$db = Connection::getConnection();
$q = trim($_GET['q']);

$stmt = $db->prepare("SELECT clients.*, (clients.credit_amount - clients.payroll_amount) As rest
						 FROM clients WHERE nom LIKE :q ORDER BY rest DESC");

$q = "%$q%";
$stmt->bindValue(':q', $q, PDO::PARAM_STR);
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_OBJ);
 ?>
<div class="main">
	<?php
	if (empty($patients)) {
		echo "<div class='alert alert-info alert-custom'>";
		echo "Aucune resultat pour: <strong>{$_GET['q']}</strong>";
		echo "</div>";
	}
	?>
	 <div class="table-responsive">
	 	<table class="table table-hover">
	 		<thead class="text-center">
	            <tr>
	                <th>Nom</th>
	                <th>Crédit</th>
	                <th>Payment</th>
	                <th>Reste</th>
	            </tr>
	        </thead>
	        <tbody>
        	<?php foreach($patients as $patient):?>
	        	<tr>
	        		<td><?=ucfirst($patient->nom)?></td>
	        		<td><?=$patient->credit_amount?></td>
	        		<td><?=$patient->payroll_amount?></td>
	        		<td><?=$patient->rest?></td>
	        	</tr>
	        <?php endforeach;?>
	        </tbody>
	 	</table>	
	 </div>
 </div>
<?php 
include 'inc/footer.php';
 ?>



