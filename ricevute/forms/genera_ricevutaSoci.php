<?php
//session_start();
include "../lib/db_login_connect.php";
include "../lib/lock.php";

if(!isset($_POST['codiceSocio']) || !isset($_SESSION['cod'])){
  echo '<script language=javascript>document.location.href="../dash/index.php?s=2"</script>';
  die;
}
else{
  $socioEmittente = $_SESSION['cod'];
  $socioDestinatario=$_POST['codiceSocio'];
}

function sostituisci($stringa){
  $cerca=array("à","è","é","ì","ò","ù", ",");//e altri
  $sostituisci=array("a'","e'","e'","i'","o'","u'", ".");//deve corrispondere
  return str_replace($cerca,$sostituisci,$stringa);
}
$query= mysqli_query($mysqli, "SELECT * FROM soci WHERE codiceSocio = $socioDestinatario");
$soci = mysqli_fetch_array($query);

$cognome = $soci['cognome'];
$nome = $soci['nome'];
$mail = $soci['mailFattura'] ;

?>
<HTML>
  <HEAD>
    <TITLE>Genera ricevuta</TITLE>
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
    function onlynumber(field) {  //Funzione per il controllo dell'inserimento di soli numeri
    if (isNaN(field.value)) {
      field.value=field.value.substr(0, field.value.length-2);
    }
  }

</script>

</HEAD>
<BODY>
  <!--<center>-->
  <p class="title">Genera ricevuta (socio <?php echo $socioDestinatario?>)</p>

  <form method="post" name="form" action="../funzioni/process_genera_ricevutaSoci.php">  <!-- Form per l'invio dei dati da registrare -->
    <fieldset id="inputs">
        <p class="others">
        <table>
          <tr>
          <input type="hidden" name="codiceSocio"  maxlength="64" value='<?php echo $socioDestinatario?>'><br>
          <td>Nome:&nbsp </td>
          <input type="hidden" name="nome" placeholder="Nome" maxlength="64" value='<?php echo $nome?>' readonly="readonly"  required >
          <td><?php echo $nome?> <br>
          </td>
        </tr>
          <tr>
            <td>Cognome:&nbsp</td>
            <input type="hidden" name="cognome" placeholder="Cognome" maxlength="64" value='<?php echo $cognome?>' readonly="readonly"  required>
            <td> <?php echo $cognome?><br>
            </td>
          </tr>
          <tr>
            <td>E-Mail:&nbsp</td>
            <td> <input type="email" name="mail" placeholder="Indirizzo Mail" maxlength="64" value='<?php echo $mail?>' required>
            </td>
          </tr>
            <?php echo "<input type='hidden' name='data' value='".date('Y-m-d')."';><br>";?>
            <input type="hidden" name="anno" maxlength="4" value='<?php
            $anno= date('Y');
            $mese= date('m');
            $giorno= date('d');
            if ($giorno<='30' && $mese<='09'){
              echo $anno;
            }else {
              echo $anno+1;
            }

            ?>'>
          <tr>
            <td>Causale:&nbsp</td>
            <td> <input  type="text" name="causale" placeholder="Causale" required autofocus><br>
            </td>
          </tr>
          <tr>
            <td>Importo:&nbsp</td>
            <td><input type="text" name="importo" placeholder="Importo (es. 10.50)" onKeyUp="onlynumber(this)" required><br>
            </td>
          </tr>
      </table>
      </p>
      <input  type="hidden" name="form" value="ok" required>
    </fieldset>
    <!--<div class="center">-->
    <fieldset id="actions">
      <input type="submit" id="submit" style=' margin-right:10px' value="Genera">
      <input type="reset" id="submit" style=' margin-right:10px' value="Reset">
    </form>
    <!-- <form action='../dash/index.php'>
    <input type='submit' id='submit' value='Annulla' />
  </form> -->
</fieldset>
<!--</center>-->
</BODY>
</HTML>
