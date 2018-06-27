<?php
session_start();
include "../lib/db_login_connect.php";

//la pagina non può essere avviata senza ricevere codice e password
if(!isset($_POST['p']) || !isset($_POST['codiceSocio']) ) {
  echo "Pagina non raggiungibile";
  die;
}
$codiceSocio = $_POST['codiceSocio'];

$verificaCodiceSocio= mysqli_query($mysqli, "SELECT * FROM soci WHERE codiceSocio = $codiceSocio");
$risposta1 = mysqli_fetch_array($verificaCodiceSocio);
$codicePresente1 = $risposta1['codiceSocio'];
if($codiceSocio != $codicePresente1){
  $redirect = "../forms/register_newUtente.php";
  echo '<script type="text/javascript">
              alert("Codice Socio non presente nel database")
              window.location.href = "'.$redirect.'"
              </script>';
  die;
}
$verificaCodiceUtente= mysqli_query($mysqli, "SELECT * FROM utenti WHERE codiceSocio = $codiceSocio");
$risposta2 = mysqli_fetch_array($verificaCodiceUtente);
$codicePresente2 = $risposta2['codiceSocio'];
if($codiceSocio === $codicePresente2){
  $redirect = "../forms/register_newUtente.php";
  echo '<script type="text/javascript">
              alert("Codice Socio già presente nel database")
              window.location.href = "'.$redirect.'"
              </script>';
  die;
}

$password = $_POST['p'];  //Salvo la password ricevuta dal metodo POST per un elaborazione successiva
$salt = uniqid(mt_rand(1, mt_getrandmax()), true);  //Creo una chiave di cifratura (sale) univoca e randomica per l'hashing in SHA1 della password
$password = sha1($password.$salt);  //Eseguo l'hashing della password, concatendandola con il sale in modo da renderla irreversibile

$privilegio = $_POST['privilegio'];

  if ($insert_query_utente = $mysqli->prepare("INSERT INTO utenti (codiceSocio, password, salt, privilegio) VALUES (?, ?, ?, ?)")) {
    $insert_query_utente->bind_param('issi', $codiceSocio, $password, $salt, $privilegio);
    $insert_query_utente->execute(); //Dopo aver preparato la query con i dati ricevuti dal form, la eseguo per riempire la tabella dei dati dell'utente
    echo '<script language=javascript>document.location.href="../login/login.php"</script>'; //Torno alla dashboard

  }
?>
