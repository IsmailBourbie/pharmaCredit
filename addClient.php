<?php session_start();
$_SESSION['title'] = 'Nouveau';
include 'inc/head.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "db_connect.php";

    $db = Connection::getConnection();
	$name = $_POST['name'];
	$error = "";
	if (empty($name)) {
		$$error = "Le nom ne peut pas etre vide";
	}
	if (!empty($error)) {
		$_SESSION['errors'] = $error;
	} else {
		// every thing is ok 
		$sql = 'SELECT * FROM clients WHERE nom = ?';
		$stmt = $db->prepare($sql);
		$stmt->execute(array($name));
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		$count = $stmt->rowCount();
		if($count > 0) {
			$_SESSION['errors'] = "Le nom dèjà existe";
		} else {
			$sql = 'INSERT INTO clients (nom) VALUES(?)';
			$stmt = $db->prepare($sql);
			if ($stmt->execute(array($name))){
				$_SESSION['success'] = 'Le nom ajouté';
				$_SESSION['name'] = $name;
				header('Location: index.php');
			};
		}
	}
}
 ?>
<div class="main">
        <h3 class="text-center">Nouveau Patient</h3>
        <?php 
            if(isset($_SESSION['errors'])) {
                echo '<div class="alert alert-danger" role="alert">';
            	echo $_SESSION['errors'];
            	echo '</div>';
                unset($_SESSION['errors']);
                }
                ?>
        <form class="reset-input" action="<?= $_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                </span>
                <input type="text" name="name" class="form-control" placeholder="Nom du patient*" required autofocus>
            </div>        
            <div class="row form-btn text-center">
                <div class="col-sm-3 col-sm-offset-3">
                    <input type="submit" class="btn-submit" name="submit" value="Enregistrer">
                </div>
                <div class="col-sm-3">
                    <input type="reset" class="btn-reset" name="reset" value="Annuler">
                </div>
            </div>
        </form>
    </div>
<?php 
include 'inc/footer.php';
 ?>