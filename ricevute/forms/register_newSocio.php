<?php
//verificare che si possa accedere solo con login da parte di un privilegio 3 o 4
include('../lib/lock.php');

?>

<HTML>
  <HEAD>
    <TITLE>Registrazione socio</TITLE>
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
  <p class="title">Registra un nuovo socio:</p>

  <form method="post" name="form" action="../funzioni/process_register_socio.php">  <!-- Form per l'invio dei dati da registrare -->
    <fieldset id="inputs">
      <p class="others"><br>Dati Socio:
      <input id="codiceSocio" type="text" name="codiceSocio" placeholder="Codice censimento" onKeyUp="onlynumber(this)" autofocus required></p>
      <input type="text" name="nome" placeholder="Nome" required>
      <input type="text" name="cognome" placeholder="Cognome"  required><br>
      Sesso:  M <input id="sesso" type="radio" name="sesso" value="M" style="width: 13px;" checked>&nbsp;&nbsp;&nbsp;
              F <input id="sesso" type="radio" name="sesso" value="F" style="width: 13px;"><br>
      <input type="date" name="dataNascita" placeholder="Data di nascita" required>
      <input type="text" name="luogoNascita" placeholder="Luogo di nascita (Facoltativo)" value=""><br>
      <input id="cf" type="text" name="cf" placeholder="Codice Fiscale" maxlength="16" >
      <input type="text" name="professione" placeholder="Professione (Facoltativo)" value=""><br>
      <input id="tel" type="text" name="cellulare" placeholder="Tel. (senza +39)" onKeyUp="onlynumber(this)" maxlength="10" value="">
      <input type="email" name="mail" placeholder="Indirizzo Mail" value="" required><br>
      <input id="indirizzo" type="text" name="indirizzo" placeholder="Indirizzo (Facoltativo)" value=""><br>
      <input type="text" name="comune" placeholder="Comune (Facoltativo)" value="">
      <input type="text" name="provincia" placeholder="Provincia (es. BA) (Facoltativo)"maxlength="2" value=""><br>

    </fieldset>
    <!--<div class="center">-->
    <fieldset id="actions">
      <input type="submit" id="submit" style=' margin-right:10px' value="Registra" onclick="return controllaCf();">
      <input type="reset" id="submit" style=' margin-right:10px' value="Reset">
    </form>
    <br><br><br>
    <!-- <form action='../dash/index.php'>
      <input type='submit' id='submit' value='Annulla' />
    </form> -->
  </fieldset>
  <!--</center>-->
</BODY>
</HTML>
