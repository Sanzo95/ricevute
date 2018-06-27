<?php
//session_start();
include "../lib/db_login_connect.php";
include "../lib/lock.php";

if(!isset($_POST['codiceSocio'])){
  echo '<script language=javascript>document.location.href="../dash/index.php?s=4"</script>';
  die;
}

$codiceSocio=$_POST['codiceSocio'];
$queryU= mysqli_query($mysqli, "SELECT privilegio FROM utenti WHERE $codiceSocio = codiceSocio");
$trovaPrivilegio = mysqli_fetch_array($queryU);
$privilegio = $trovaPrivilegio['privilegio'];
if(isset($_SESSION['privilegio'])){
  if($_SESSION['privilegio'] != "4"){
    if ($privilegio == "4" || $codiceSocio == '1031757'){
      echo '<script type="text/javascript">alert("Utente non modificabile");</script>';
      echo '<script language=javascript>document.location.href="../login/logout.php"</script>';
      die;
    }
  }
}

if(isset($_POST['censito'])){
  if ($_POST['censito'] == 'no'){
    $update_query = mysqli_query($mysqli, "UPDATE soci SET censito = 'no' WHERE soci.codiceSocio = $codiceSocio");
    echo '<script type="text/javascript">alert("Socio rimosso dal database");</script>';
    echo '<script language=javascript>document.location.href="../dash/index.php?s=4"</script>';
    die;
  }
}


function sostituisci($stringa){
  $cerca=array("a'","e'","e'","i'","o'","u'");//deve corrispondere
  $sostituisci=array("à","è","é","ì","ò","ù");//e altri
  return str_replace($cerca,$sostituisci,$stringa);
}

$queryS= mysqli_query($mysqli, "SELECT * FROM soci WHERE $codiceSocio = codiceSocio");
$soci = mysqli_fetch_array($queryS);

$cognome = sostituisci($soci['cognome']);
$nome = sostituisci($soci['nome']);
$sesso= $soci['sesso'];
$dataNascita= $soci['dataNascita'];
$luogoNascita= sostituisci($soci['luogoNascita']);
$cf= $soci['cf'];
$professione= sostituisci($soci['professione']);
$mail= $soci['mail'];
$cellulare= $soci['cellulare'];
$indirizzo= sostituisci($soci['indirizzo']);
$comune= sostituisci($soci['comune']);
$provincia= $soci['provincia'];
$mailFattura= $soci['mailFattura'];
?>
<HTML>
  <HEAD>
    <TITLE>Gestisci Soci</TITLE>
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />  <!-- css per lo stile della pagina -->
    <style>
    p.title { /*Stile aggiuntivo per questa pagina*/
      font: 20px helvetica, sans-serif;
      font-weight: bold;
    }
    p.others {
      font: 16px helvetica, sans-serif;
    }
    .center {
      width: 60%;
      top: 50%;
      left: 50%;
      margin-right: -43%;
    }
    </style>

    <script type="text/javascript">
    function controllaCf() {  //Funzione per il controllo della lunghezza del CF
      if (document.getElementById("cf").value.length != 16) {
        alert("Inserire un codice fiscale valido.");
        document.getElementById("cf").focus();
        return false;
      }
      else {
        return true;
      }
    }

    function onlynumber(field) {  //Funzione per il controllo dell'inserimento di soli numeri
    if (isNaN(field.value)) {
      field.value=field.value.substr(0, field.value.length-2);
    }
  }

</script>

</HEAD>
<BODY>
  <!--<center>-->
  <p class="title">Gestisci socio:</p>

    <form method="post" name="form" action="../funzioni/process_register_socio.php">  <!-- Form per l'invio dei dati da registrare -->
      <fieldset id="inputs">
        <p class="others"><br>Dati:<br></p>
        <input id="codiceSocio" type="text" name="codiceSocio" placeholder="Codice socio" onKeyUp="onlynumber(this)" maxlength="64" value='<?php echo $codiceSocio?>' readonly="readonly"  autofocus required></p>
        <?php
        echo "<input type='text' name='nome' placeholder='Nome' maxlength='64' value='$nome' required> ";
        echo "<input type='text' name='cognome' placeholder='Cognome' maxlength='64' value='$cognome' required> <br>";
        echo "Sesso: ";
        if($sesso === "m" || $sesso === "M" ){
          echo "M <input id='sesso' type='radio' name='sesso' value='M' style='width: 13px;' checked>&nbsp;&nbsp;&nbsp;";
          echo "F <input id='sesso' type='radio' name='sesso' value='F' style='width: 13px;'> <br>";
        }else {
          echo "M <input id='sesso' type='radio' name='sesso' value='M' style='width: 13px;' >&nbsp;&nbsp;&nbsp;";
          echo "F <input id='sesso' type='radio' name='sesso' value='F' style='width: 13px;' checked> <br>";
        }
        ?>
        <input type="date" name="dataNascita" placeholder="Data di nascita" value='<?php echo $dataNascita?>' required>
        <input type="text" name="luogoNascita" placeholder="Luogo di nascita (Facoltativo)" value='<?php echo $luogoNascita?>'><br>
        <input id="cf" type="text" name="cf" placeholder="Codice Fiscale" maxlength="16" value='<?php echo $cf?>'>
        <input type="text" name="professione" placeholder="Professione (Facoltativo)" value='<?php echo $professione?>'><br>
        <input id="tel" type="text" name="cellulare" placeholder="Tel. (senza +39)" onKeyUp="onlynumber(this)" maxlength="10" value='<?php echo $cellulare?>'>
        <input type="email" name="mail" placeholder="Indirizzo Mail" value='<?php echo $mail?>' required><br>
        <input id="indirizzo" type="text" name="indirizzo" placeholder="Indirizzo (Facoltativo)" value='<?php echo $indirizzo?>'><br>
        <input type="text" name="comune" placeholder="Comune (Facoltativo)" value='<?php echo $comune?>'>
        <input type="text" name="provincia" placeholder="Provincia (es. BA) (Facoltativo)"maxlength="2" value='<?php echo $provincia?>'><br>
        <input type="email" name="mailFattura" placeholder="Indirizzo Mail Genitore" maxlength="64" value='<?php echo $mailFattura?>' required><br>

        <?php
        if($_SESSION['cod'] == $codiceSocio){
          echo "<p class='others'>Privilegio &nbsp
          <select>
          <option>$privilegio</option>
          </select>";
        }else if($privilegio ==1){
          echo "<p class='others'>Privilegio &nbsp
          <select name='privilegio'>
          <option value='1'>Nuovo utente: 1</option>
          <option value='2'>Ragazzo: 2</option>
          <option value='3'>Capo: 3</option>
          </select>";
        }else if($privilegio ==2){
          echo "<p class='others'>Privilegio &nbsp
          <select name='privilegio'>
          <option value='2'>Ragazzo: 2</option>
          <option value='1'>Nuovo utente: 1</option>
          <option value='3'>Capo: 3</option>
          </select>";
        }else if($privilegio ==3){
          echo "<p class='others'>Privilegio &nbsp
          <select name='privilegio'>
          <option value='3'>Capo: 3</option>
          <option value='1'>Nuovo utente: 1</option>
          <option value='2'>Ragazzo: 2</option>
          </select>";
        }else if($privilegio ==4){
          echo "<p class='others'>Privilegio &nbsp
          <select name='privilegio'>
          <option value='4'>Super Admin: 4</option>
          <option value='1'>Nuovo utente: 1</option>
          <option value='2'>Ragazzo: 2</option>
          <option value='3'>Capo: 3</option>
          </select>";
        }
        ?>

      </p>
      <input  type="hidden" name="form" value="ok" required>
    </fieldset>
    <!--<div class="center">-->
    <fieldset id="actions">
      <input type="submit" id="submit" style=' margin-right:10px' value="Modifica" onclick="return controllaCf();">
      <input type="reset" id="submit" style=' margin-right:10px' value="Reset">
    </form>
    <!-- <form action='../dash/index.php'>
    <input type='submit' id='submit' value='Annulla' />
  </form> -->
</fieldset>
<!--</center>-->
</BODY>
</HTML>
