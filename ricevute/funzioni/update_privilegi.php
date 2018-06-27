<?php
include "../lib/db_login_connect.php";
//controlla se la sessione possiede un privilegio, anche in caso di refresh
if(!isset($_SESSION['privilegio']) ) {
  session_start();
  if(!isset($_SESSION['privilegio']) ) {
    echo "Pagina non raggiungibile";
    die;
  }
}
//la pagina non può essere avviata senza avere i giusti privilegi
if($_SESSION['privilegio'] != "3" && $_SESSION['privilegio'] != "4" ) {
  echo "Pagina non raggiungibile";
  die;
}

if(!isset($_POST['socio'])){
  die;
}

$socio = $_POST['socio'];

$update_query = mysqli_query($mysqli, "UPDATE utenti SET privilegio = '2' WHERE utenti.codiceSocio = $socio");

$redirect = "../dash/index.php";
echo '<script type="text/javascript">
            window.location.href = "'.$redirect.'"
            </script>';
die;
?>
