<?php session_start();
require 'config/config.php';
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

$q = "$q%";
$stmt->bindValue(':q', $q, PDO::PARAM_STR);
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_OBJ);
 ?>
<div class="main" id="patients">
	<?php
	if (empty($patients)) {
		echo "<div class='alert alert-info alert-custom'>";
		echo "Aucune resultat pour: <strong>{$_GET['q']}</strong>";
		echo "</div>";
	}
	?>
	 <div class="table-responsive">
	 	<table class="table tab-patients">
	 		<thead class="text-center">
	            <tr>
	                <th>Nom</th>
	                <th>Crédit</th>
	                <th>Versement</th>
	                <th>Reste</th>
	                <th>Action</th>
	            </tr>
	        </thead>
	        <tbody>
        	<?php foreach($patients as $patient):?>
	        	<tr>
	        		<td><?=ucfirst($patient->nom)?></td>
	        		<td><?=number_format((float)$patient->credit_amount, 2, '.', ' ')?></td>
	        		<td><?=number_format((float)$patient->payroll_amount, 2, '.', ' ')?></td>
	        		<td><?=number_format((float)$patient->rest, 2, '.', ' ')?></td>
	        		<td>
	        			<button class="btn btn-info detail-btn" data-toggle="modal" data-target="#detail-modal">Detail</button>
	        			<button class="btn btn-success verser-btn" data-toggle="modal" data-target="#verser-modal">Verser</button>
	        			<button class="btn btn-danger credit-btn">Crédit</button>
	        		</td>
	        	</tr>
	        <?php endforeach;?>
	        </tbody>
	 	</table>	
	</div>
</div>
<!-- Modal of payroll -->
<div class="modal fade" id="verser-modal" tabindex="-1" aria-labelledby="verserModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h4 class="modal-title" id="verserModalLabel">Ajouter un versement</h4>
		  </div>
		  <div class="modal-body">
		  	<div class="alert alert-success" style="display: none;">Un versement ajouter avec successé</div>
		    <form>
		      <div class="form-group">
		        <label for="patient_name" class="control-label">Nom:</label>
		        <input type="text" name="name" class="form-control" id="patient_name" disabled>
		      </div>
		      <div class="form-group">
		        <label for="payroll_amount" class="control-label">
		        	Versement:
		    	</label>
		        <input type="number" name="payroll_amount" class="form-control next-input" id="payroll_amount">
		      </div>
					<div class="form-group">
		        <label for="payroll_amount" class="control-label">
		        	Notification:
		    	</label>
					<input type="text" name="notif" class="form-control next-input" id="payroll_notif">
		      </div>
		      <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			    <button type="submit" id="confirm-payroll" class="btn btn-primary">Confirmer</button>
		 	  </div>
		    </form>
		  </div>
		</div>
	</div>
</div>

<!-- Modal of detail -->
<div class="modal fade" id="detail-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Historique de <span id="span_name_patient"></span></h4>
      </div>
      <div class="modal-body">
      	<div class="table-responsive">
		 	<table class="table table-striped">
		 		<thead class="text-center">
		            <tr>
		                <th>Crédit</th>
		                <th>Versement</th>
		                <th>Notification</th>
		                <th>Date</th>
		            </tr>
		        </thead>
		        <tbody>
		        	<tr>
		        		
		        	</tr>
	        	</tbody>
	 		</table>	
		</div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php 
include 'inc/footer.php';
 ?>



