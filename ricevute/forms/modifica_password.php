<?php
if (!isset($_SESSION['autorizzato']) || !isset($_SESSION['cod'])) {
echo "Pagina non raggiungibile";
die;
}
?>
<HTML>
<HEAD>
<TITLE>Modifica Password</TITLE>
<link href="../login/admin.css" rel="stylesheet" type="text/css" />  <!-- css per lo stile della pagina -->
<script type="text/javascript">

function controllaLunghezzaPassw() {  //Funzione per il controllo della lunghezza della psw
    if (document.getElementById("newPw").value.length < 6) {
      alert("Inserire almeno sei caratteri per la password.");
      document.getElementById("pass").focus();
      return false;
      }
    else {
      return true;
      }
    }

    function controllaPw() {  //Funzione per il controllo della lunghezza del CF
        if (document.getElementById("newPw").value != document.getElementById("newPw2").value) {
          alert("Le password inserite non sono uguali.");
          document.getElementById("newPw2").focus();
          return false;
          }
        else {
        return true;
          }
        }
</script>
<style>
p.title { /*Stile aggiuntivo per questa pagina*/
    font: 20px helvetica, sans-serif;
    font-weight: bold;
}

</style>

</HEAD>
<BODY>
  <p class="title">Modifica la password dell'account</p><br>
  <form method="post" action="../funzioni/process_modifica_password.php">  <!-- Form per l'invio dei dati da registrare -->
  <fieldset id="inputs">
    <input type="password" name="oldPw" placeholder="Vecchia Password" required><br><br><br>
    <input type="password" id='newPw' name="newPw" placeholder="Nuova Password"required><br>
    <input type="password" id='newPw2' name="newPw2" placeholder="Conferma Nuova Password"required><br>
  </fieldset>
  <fieldset id="actions">
    <input type="submit" id="submit" style="margin-right:10px" value="Modifica" onclick="return controllaPw() && controllaLunghezzaPassw();">
    <input type="reset" id="submit" style="margin-right:10px" value="Reset">
  </form><br><br><br>
  <form action='../dash/index.php'>
      <input type='submit' style="margin-right:10px" id='submit' value='Annulla' />
  </form>
  </fieldset>
</BODY>
</HTML>
