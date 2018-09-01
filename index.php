<?php
session_start(); 
include 'inc/head.php';
$name = isset($_SESSION['name']) ? $_SESSION['name'] : "";
unset($_SESSION['name']);
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success cusstom-alert">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
?>
    <!-- Start add credit form -->
    <div class="main">
        <h3 class="text-center">Nouveau Crédit</h3>
        <?php 
            if(isset($_SESSION['errors_add_credit'])) {
                echo '<div class="alert alert-danger" role="alert">';
                    foreach($_SESSION['errors_add_credit'] as $err) {echo "* " . $err . "<br>";}
                 echo '</div>';
                 unset($_SESSION['errors_add_credit']);
                }
                ?>
        <form action="addCredit.php" method="post" autocomplete="off">
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                </span>
                <input type="text" name="name" class="form-control next-input" placeholder="Nom du patient*" value="<?= $name?>" required autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                </span>
                <input type="number" name="credit" class="form-control next-input" placeholder="Montant de crédit*" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </span>
                <input type="text" name="payment" class="form-control next-input" placeholder="Montant versé">
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </span>
                <textarea name="notif" class="form-control next-input" placeholder="Ajouter une notification.." rows="3" maxlength="255"></textarea>
            </div>
            <div class="row form-btn text-center">
                <div class="col-sm-3 col-sm-offset-3">
                    <input type="submit" class="btn-submit next-input" name="submit" value="Enregistrer">
                </div>
                <div class="col-sm-3">
                    <input type="reset" class="btn-reset" name="reset" value="Annuler">
                </div>
            </div>
        </form>
    </div>

<?php include 'inc/footer.php'; ?>