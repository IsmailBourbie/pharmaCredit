
<!-- Includ bootstrap's navbar  -->
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?=URL_ROOT?>">Bourbie Pharm</a>
        </div>
        <div class="collapse navbar-collapse">
            <form action="patients.php" class="navbar-form navbar-left" action="" method="get">
                <div class="form-group">
                    <input type="text" id="search-input" name="q" class="form-control" placeholder="Search" autocomplete="off">
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" id="Nouveau" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nouveau <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=URL_ROOT?>addClient.php">Patient</a></li>
                        <li><a href="<?=URL_ROOT?>">Crédit</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?=URL_ROOT?>statistiques.php" id="Statistiques">Statistiques</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>