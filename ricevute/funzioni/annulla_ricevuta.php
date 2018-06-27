<?php
session_start();
include '../lib/db_login_connect.php';
include('../lib/lock2.php');

if(!isset($_POST['file']) || !isset($_POST['stato'])) {
  die;
}

$filename = $_POST['file'];
$stato = $_POST['stato'];

$annullaRicevuta = $mysqli->prepare("UPDATE ricevute SET stato = ?  WHERE file = '$filename'");
$annullaRicevuta->bind_param('s', $stato);
$annullaRicevuta->execute();

echo '<script language=javascript>document.location.href="../dash/index.php?s=3"</script>';

?>
