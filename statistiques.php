<?php session_start();
require 'config/config.php';
require 'inc/head.php';

require "db_connect.php";
$db = Connection::getConnection();
$general_stats = '';
// get general stast
$stmt = $db->prepare('SELECT count(*) As clients_num, SUM(clients.credit_amount) As all_credit, (SUM(clients.credit_amount) - SUM(clients.payroll_amount)) As all_rest FROM clients');
if ($stmt->execute()) {
	$general_stats = $stmt->fetch(PDO::FETCH_OBJ);
}

// get top 5 rest haha
$stmt = $db->prepare('SELECT clients.*, (credit_amount - payroll_amount) AS rest FROM `clients` WHERE 1 ORDER BY rest DESC LIMIT 5');
if ($stmt->execute()) {
	$top_rest = $stmt->fetchAll(PDO::FETCH_OBJ);
}

// get all who outdated 1000
$stmt = $db->prepare('SELECT clients.*, (clients.credit_amount - clients.payroll_amount) As rest
						 FROM clients WHERE (clients.credit_amount - clients.payroll_amount) > 1000');
if ($stmt->execute()) {
	$more_100 = $stmt->fetchAll(PDO::FETCH_OBJ);
}
// var_dump($general_stats);
// echo('<br>');
// var_dump($top_rest);
// echo('<br>');
// var_dump($more_100);
// die();
 ?>
<div class="main-lg">
	<div>
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
	    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Général</a></li>
	    <li role="presentation"><a href="#plus_credit" aria-controls="plus_credit" role="tab" data-toggle="tab">Le plus de crédit</a></li>
	    <li role="presentation"><a href="#list_noire" aria-controls="list_noire" role="tab" data-toggle="tab">La liste noire</a></li>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="general">
    		<div class="table-responsive">
    			<table class="table general">
    				<tbody>
    					<tr>
    						<td class="h4">Nombre des clients</td>
    						<td><?=$general_stats->clients_num?></td>
    					</tr>
    					<tr>
    						<td class="h4">Crédit Totale</td>
    						<td><?=$general_stats->all_credit?></td>
    					</tr>
    					<tr>
    						<td class="h4">Reste Total</td>
    						<td><?=$general_stats->all_rest?></td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
	    </div>
	    <div role="tabpanel" class="tab-pane" id="plus_credit">
	    	<div class="table-responsive">
	    			<table class="table table-hover">
	    				<thead>
	    					<tr>
	    						<th>Nom</th>
	    						<th>Crédit</th>
	    						<th>Versement</th>
	    						<th>Reste</th>
	    					</tr>
	    				</thead>
	    				<tbody>
    					<?php foreach($top_rest as $r):?>
    						<tr class="linked" data-href="<?=URL_ROOT . 'patients.php?q=' . $r->nom?>">
    							<td><?=$r->nom?></td>
    							<td><?=$r->credit_amount?></td>
    							<td><?=$r->payroll_amount?></td>
    							<td><?=$r->rest?></td>
    						</tr>
    					<?php endforeach;?>
	    				</tbody>
	    			</table>
	    		</div>
	    </div>
	    <div role="tabpanel" class="tab-pane" id="list_noire">
	    	<div class="table-responsive">
	    			<table class="table table-hover">
	    				<thead>
	    					<tr>
	    						<th>Nom</th>
	    						<th>Crédit</th>
	    						<th>Versement</th>
	    						<th>Reste</th>
	    					</tr>
	    				</thead>
	    				<tbody>
    					<?php foreach($more_100 as $r):?>
    						<tr class="linked" data-href="<?=URL_ROOT . 'patients.php?q=' . $r->nom?>">
    							<td><?=$r->nom?></td>
    							<td><?=$r->credit_amount?></td>
    							<td><?=$r->payroll_amount?></td>
    							<td><?=$r->rest?></td>
    						</tr>
    					<?php endforeach;?>
	    				</tbody>
	    			</table>
	    		</div>
	    </div>
	  </div>
	</div>
</div>
<?php 
include 'inc/footer.php';
 ?>



