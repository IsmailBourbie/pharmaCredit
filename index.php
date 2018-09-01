<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nouveau</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <!-- Includ bootstrap's navbar  -->
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Bourbie Pharm</a>
            </div>
            <div class="collapse navbar-collapse">
                <form class="navbar-form navbar-left" action="" method="get">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search" autocomplete="off">
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" id="Nouveau">Nouveau</a>
                    </li>
                    <li>
                        <a href="#" id="Crédits">Crédits</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Start add credit form -->
    <div class="main">
        <h3 class="text-center">Nouveau Crédit</h3>
        <?php 
            if(isset($_SESSION['errors'])) {
                echo '<div class="alert alert-danger" role="alert">';
                    foreach($_SESSION['errors'] as $err) {echo "* " . $err . "<br>";}
                 echo '</div>';
                 unset($_SESSION['errors']);
                }
                ?>
        <form action="addCredit.php" method="post" autocomplete="off">
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                </span>
                <input type="text" name="name" class="form-control next-input" placeholder="Nom du patient*" required>
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
                <textarea name="notif" class="form-control next-input" placeholder="Ajouter une notification.." rows="3"></textarea>
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

    <script src="js/jquery-1.12.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
</body>

</html>