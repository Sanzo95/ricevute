<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['cod'])) {
  echo "<h1>Devi prima aver effettuato il login.<br>Clicca <a href='../login/login.php'><font color='blue'>qui</font></a>.</h1>";
  die;
}
//TO DO TASTI ELIMINA CHE GENERANO UNA CONFERMA;
include "choices.php";
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Francesco Sanzone">

  <title>Ricevute</title>

  <link href="../css/admin.css" rel="stylesheet" type="text/css" />
  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="css/metisMenu.min.css" rel="stylesheet">

  <!-- Timeline CSS -->
  <link href="css/timeline.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/startmin.css" rel="stylesheet">

  <!-- Morris Charts CSS -->
  <link href="css/morris.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<body>

  <div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Ricevute</a>
      </div>

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <!-- Top Navigation: Left Menu -->
      <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li><a href="index.php"><i class="fa fa-home fa-fw"></i> Home</a></li>
      </ul>

      <!-- Sidebar -->
      <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">

          <ul class="nav" id="side-menu">
            <li>
              <a href="index.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <?php
            // ADMIN allora fa le stesse cose di Livello 3, prevedere in "modifica elenco soci" la clausola in base al livello3/4
            //<i class="fa fa-send fa-fw"></i> invia ricevuta via mail
            //<i class="fa fa-gear fa-fw"></i> impostazioni (??)
            if(isset($_SESSION['autorizzato'])){
              echo '  <li>
              <a href="#"><i class="fa fa-sitemap fa-fw"></i> Funzioni <span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">';
              switch($_SESSION['privilegio']){
                case 1:
                echo '
                <li>
                <i class="fa fa-television fa-fw"></i>Pagina in aggiornamento
                </li>

                </ul>
                </li>';
                /*<li>
                <a href="?s=19"><i class="fa fa-cog fa-fw"></i>Modifica Password</a>
                </li>*/
                break;
                case 2:
                echo '
                <li>
                <a href="?s=3"><i class="fa fa-television fa-fw"></i>Visualizza ricevute</a>
                </li>
                <li>
                <a href="?s=1"><i class="fa fa-pencil fa-fw"></i>Genera ricevute</a>
                </li>

                </ul>
                </li>';
                /*<li>
                <a href="?s=19"><i class="fa fa-cog fa-fw"></i>Modifica Password</a>
                </li>*/
                break;
                case 4:
                case 3:
                echo '
                <li>
                <a href="?s=7"><i class="fa fa-user fa-fw"></i>Registra nuovo socio</a>
                </li>
                <li>
                <a href="?s=4"><i class="fa fa-user fa-fw"></i>Gestisci soci</a>
                </li>
                <li>
                <a href="?s=3"><i class="fa fa-television fa-fw"></i>Visualizza ricevute</a>
                </li>
                <li><a href="?#"><i class="fa fa-pencil fa-fw"></i>Genera ricevute<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                </li>
                <li>
                <a href="?s=2"><i class="fa fa-pencil fa-fw"></i>Genera ricevute verso soci</a>
                </li>
                </li>
                <li>
                <a href="?s=1"><i class="fa fa-pencil fa-fw"></i>Genera ricevute verso terzi</a>
                </li>
                </li>
                </ul>
                </li>

                </ul>
                </li>';
                /*<li>
                <a href="?s=19"><i class="fa fa-cog fa-fw"></i>Modifica Password</a>
                </li>*/
                break;
                default:
                break;
              }
            }
            ?>
            <li>
              <a href="../login/logout.php" class="active"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
          </ul>

        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header"></h1>
          </div>
        </div>
        <?php include($scelta); ?> <!-- ... Contenuto del wrapper ... -->
      </div>
    </div>

  </div>

  <script src="js/jquery.min.js"></script>

  <script src="js/bootstrap.min.js"></script>

  <script src="js/metisMenu.min.js"></script>

  <script src="js/startmin.js"></script>


</body>
</html>
