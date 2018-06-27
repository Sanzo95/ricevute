<?php
session_start();
include "../lib/db_login_connect.php";

//la pagina non può essere avviata senza ricevere codice e password
if(!isset($_POST['codiceSocio']) ) {
  echo "Pagina non raggiungibile";
  die;
}

$codiceSocioRicevuto = $_POST['codiceSocio'];

$verificaCodiceSocio= mysqli_query($mysqli, "SELECT * FROM soci WHERE codiceSocio = $codiceSocioRicevuto");
$risposta = mysqli_fetch_array($verificaCodiceSocio);
$codiceSocioDatabase = $risposta['codiceSocio'];
if(!isset($_POST['form'])){
  if($codiceSocioRicevuto === $codiceSocioDatabase){
    $redirect = "../dash/index.php?s=7";
    echo '<script type="text/javascript">
    alert("Codice Socio già presente nel database")
    window.location.href = "'.$redirect.'"
    </script>';
    die;
  }
  $maxDate=date('Y-m-d', strtotime('-8 year', strtotime(date('Y-m-d'))));
  $minDate=date('Y-m-d', strtotime('-100 year', strtotime(date('Y-m-d'))));
  if($_POST['dataNascita'] >= $maxDate || $_POST['dataNascita'] <= $minDate) {
    $redirect = "../dash/index.php?s=7";
    echo '<script type="text/javascript">
    alert("Inserire una data di nascita corretta")
    window.location.href = "'.$redirect.'"
    </script>';
    die;
  }
}

function sostituisci($stringa){
  $cerca=array("à","è","é","ì","ò","ù", ",", "'");//e altri
  $sostituisci=array("a'","e'","e'","i'","o'","u'", ".", "\'");//deve corrispondere
  return str_replace($cerca,$sostituisci,$stringa);
}

//rimuovo caratteri accentati
$cognome = strtoupper(sostituisci($_POST['cognome']));
$nome = strtoupper(sostituisci($_POST['nome']));
$indirizzo = strtoupper(sostituisci($_POST['indirizzo']));
$dataNascita = $_POST['dataNascita'];
$luogoNascita = strtoupper(sostituisci($_POST['luogoNascita']));
$professione = strtoupper(sostituisci($_POST['professione']));
$comune = strtoupper(sostituisci($_POST['comune']));
$sesso = $_POST['sesso'];
$cf = strtoupper(sostituisci($_POST['cf']));
$mail = $_POST['mail'];
$cellulare =$_POST['cellulare'];
$provincia =  $_POST['provincia'];

if(isset($_POST['mailFattura'])){
  $mailFattura = $_POST['mailFattura'];
}else{
  $mailFattura = $_POST['mail'];
}



if(!isset($_POST['form'])){
  if ($insert_query_socio = $mysqli->prepare("INSERT INTO soci (codiceSocio, cognome, nome,
    sesso, dataNascita, luogoNascita, cf,
    professione, mail, cellulare, indirizzo, comune,
    provincia, mailFattura)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
      $insert_query_socio->bind_param('isssssssssssss', $codiceSocioRicevuto, $cognome, $nome,
      $sesso, $dataNascita, $luogoNascita, $cf,
      $professione, $mail, $cellulare, $indirizzo, $comune,
      $provincia, $mailFattura);
      $insert_query_socio->execute(); //Dopo aver preparato la query con i dati ricevuti dal form, la eseguo per riempire la tabella dei dati dei soci
echo '<script type="text/javascript"> alert("Socio registrato con successo") </script>';
      echo '<script language=javascript>document.location.href="../dash/index.php"</script>'; //Torno alla dashboard

    }
  }else{
    $update_query = mysqli_query($mysqli, "UPDATE soci SET cognome = '$cognome', nome = '$nome', sesso = '$sesso',
      dataNascita = '$dataNascita', luogoNascita = '$luogoNascita', cf = '$cf', professione = '$professione', mail = '$mail',
      cellulare ='$cellulare', indirizzo = '$indirizzo', comune = '$comune', provincia = '$provincia', mailFattura = '$mailFattura'
      WHERE soci.codiceSocio = $codiceSocioRicevuto");

      if(isset($_POST['privilegio'])){
        $privilegio = $_POST['privilegio'];
        if($codiceSocioRicevuto === $_SESSION['cod']){
          $_SESSION['privilegio'] = $privilegio;
        }
        $update_query = mysqli_query($mysqli, "UPDATE utenti SET privilegio = '$privilegio'
          WHERE utenti.codiceSocio = $codiceSocioRicevuto");
        }

        echo '<script type="text/javascript"> alert("Socio modificato con successo") </script>';
        echo '<script language=javascript>document.location.href="../dash/index.php"</script>'; //Torno alla dashboard

      }

      ?>
