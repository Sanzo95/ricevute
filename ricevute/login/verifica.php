<?php
session_start(); //inizio la sessione
//includo i file necessari a collegarmi al db con relativo script di accesso
include '../lib/db_login_connect.php';

//variabili POST con anti sql Injection
$codiceSocio=mysqli_real_escape_string($mysqli, $_POST['codiceSocio']); //faccio l'escape dei caratteri dannosi
$retrieve_salt = "SELECT * FROM utenti WHERE codiceSocio = '$codiceSocio'";
$verificaSocio= mysqli_query($mysqli, $retrieve_salt) or die (mysqli_error());
$risposta = mysqli_fetch_array($verificaSocio);
$codiceSocioDatabase = $risposta['codiceSocio'];
$salt=$risposta['salt'];
$privilegio=$risposta['privilegio'];
$password= sha1($_POST['password'].$salt); //sha1 cifra la password anche qui in questo modo corrisponde con quella del db
if($codiceSocio != $codiceSocioDatabase){
  $redirect = "../login/login.php";
  echo '<script type="text/javascript">
  alert("Codice Socio non registrato")
  window.location.href = "'.$redirect.'"
  </script>';
  die;
}

$query = "SELECT * FROM utenti WHERE codiceSocio = '$codiceSocio' AND password = '$password' ";
$ris = mysqli_query($mysqli, $query) or die (mysqli_error());
$riga=mysqli_fetch_array($ris);

/*Prelevo l'identificativo dell'utente */
$cod=$riga['codiceSocio'];

/* Effettuo il controllo */
if ($cod == NULL){
  $trovato = 0 ;
  $redirect = "../login/login.php";
  echo '<script type="text/javascript">
  alert("Password errata")
  window.location.href = "'.$redirect.'"
  </script>';
  die;
}
else{ $trovato = 1;}

/* Username e password corrette */
if($trovato === 1) {

  /*Registro la sessione*/
  $_SESSION['autorizzato'] = 1;

  /*Registro il codice dell'utente*/
  $_SESSION['cod'] = $cod;

  $_SESSION['privilegio'] = $privilegio;
  /*Redirect alla pagina riservata*/
  echo '<script language=javascript>document.location.href="../dash/index.php"</script>';

} else {

  /*Username e password errati, redirect alla pagina di login*/
  echo '<script language=javascript>document.location.href="login.php"</script>';

}
?>
