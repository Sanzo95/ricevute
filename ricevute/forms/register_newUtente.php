<?php
session_start();
if(isset($_SESSION['privilegio'])){
  die;
}
?>
<HTML>
  <HEAD>
    <TITLE>Registrazione utente</TITLE>
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
    function controllaLunghezzaPassw() {  //Funzione per il controllo della lunghezza della psw
      if (document.getElementById("pass").value.length < 6) {
        alert("Inserire almeno sei caratteri per la password.");
        document.getElementById("pass").focus();
        return false;
      }
      else {
        return true;
      }
    }

  </script>

</HEAD>
<BODY>
  <!--<center>-->
  <p class="title">Registra un nuovo utente:</p>

  <form method="post" name="form" action="../funzioni/process_register_utente.php">  <!-- Form per l'invio dei dati da registrare -->
    <fieldset id="inputs">
      <input id="codiceSocio" type="text" name="codiceSocio" placeholder="Codice personale (censimento)" onKeyUp="onlynumber(this)" autofocus required>
      <input id="pass" type="password" name="p" placeholder="Password"required><br>
      <input type="hidden" name="privilegio" value=1> <!-- Enum(0,1,2,3): value =1 è il primo.-->
    </fieldset>
    <!--<div class="center">-->
    <fieldset id="actions">
      <input type="submit" id="submit" style=' margin-right:10px' value="Registra" onclick="return controllaLunghezzaPassw();">
      <input type="reset" id="submit" style=' margin-right:10px' value="Reset">
    </form>
  <br><br><br>
   <form action='../login/login.php'>
    <input type='submit' id='submit' value='<-- Login' />
  </form>
</fieldset>
<!--</center>-->
</BODY>
</HTML>
