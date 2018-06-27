<?php
//session_start();
$scelta;
//TO DO TASTI ELIMINA CHE GENERANO UNA CONFERMA;
if(!isset($_GET['s']) || $_GET['s']==0)
{
  if(($_SESSION['privilegio']==='3' || $_SESSION['privilegio']==='4')){
    $scelta = "../forms/accept_utente.php";
  }else{
    $scelta = "../forms/empty.php";
  }
}else if ($_GET['s']==1)
{
  $scelta = "../forms/genera_ricevutaTerzi.php";
}else if ($_GET['s']==2)
{//elenco soci per genera ricevuta Soci
  $scelta = "../forms/elencoSoci.php";
}else if ($_GET['s']==3)
{//visualizza ricevute
  $scelta = "../forms/visualizza_ricevute.php";
}else if ($_GET['s']==4)
{//elenco soci per gestisci soci
  $scelta = "../forms/elencoSoci.php";
}else if ($_GET['s']==5)
{
  $scelta = '../forms/genera_ricevutaSoci.php';
}else if ($_GET['s']==6)
{//gestisci soci
  $scelta = '../forms/gestisci_soci.php';
}else if ($_GET['s']==7)
{
  $scelta = '../forms/register_newSocio.php';
}else if ($_GET['s']==19)
{//nascosta
  $scelta = '../forms/modifica_password.php';
}else
{
  $scelta = "empty.php";
}

?>
