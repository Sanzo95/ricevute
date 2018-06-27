<?php
include "../lib/db_login_connect.php";
//controlla se la sessione possiede un privilegio, anche in caso di refresh
if(!isset($_SESSION['privilegio']) ) {
  session_start();
  if(!isset($_SESSION['privilegio']) ) {
    echo "Pagina non raggiungibile";
    die;
  }
}
//la pagina non può essere avviata senza avere i giusti privilegi
if($_SESSION['privilegio'] != "3" && $_SESSION['privilegio'] != "4" ) {
  echo "Pagina non raggiungibile";
  die;
}
?>
<HTML>
  <HEAD>
    <TITLE>Benvenuto - Accetta iscrizioni</TITLE>
    <style>
    p.title { /*Stile aggiuntivo per questa pagina*/
      font: 20px helvetica, sans-serif;
      font-weight: bold;
    }
    p.others {
      font: 18px helvetica, sans-serif;
      font-weight: bold;
    }
    p.others2 {
      margin-right: 5px;
      font: 16px helvetica, sans-serif;
    }
    p.others3{
      margin: auto;
      align-content: center;
      align-items: center;
      align-self: center;
      margin-left: 10px;
      margin-top: auto;
      font: 16px helvetica, sans-serif;
    }
    </style>
  </HEAD>
  <BODY>

    <?php
    echo '<p class="title" style="font: 35px helvetica, sans-serif;
    font-weight: bold;">Benvenuto</p><br>
    <p class="others" style="font: 18px helvetica, sans-serif;">Seleziona una funzione dal menù a sinistra</p><br>';

    $count = mysqli_query($mysqli, "SELECT count(codiceSocio) as rimanenti FROM utenti  WHERE privilegio ='1'");
    $flag = mysqli_fetch_array($count);
    if($flag['rimanenti'] != '0') {
      echo "<p class='title'>Nuovi utenti registrati:</p><br>
      <table border=2>
      <td><p class='others2'><b>&nbspCodice Socio</p></td>
      <td><p class='others2'><b>&nbspCognome</p></td>
      <td><p class='others2'><b>&nbspNome</p></td>
      <td><p class='others2'><b>&nbspPrivilegio</p></td>
      <td><p class='others2'><b>&nbspAggiorna Privilegio</p></td>";

      $query = mysqli_query($mysqli, "SELECT utenti.codiceSocio, cognome, nome, privilegio FROM soci inner JOIN utenti on soci.codiceSocio = utenti.codiceSocio  WHERE privilegio ='1'");

      while($utenti=mysqli_fetch_array($query)){
        $socio=$utenti['codiceSocio'];
        echo "<tr>
        <td><p class='others2'>&nbsp".$socio."</p></td>
        <td><p class='others2'>&nbsp".$utenti['cognome']."</p></td>
        <td><p class='others2'>&nbsp".$utenti['nome']."</p></td>
        <td><p class='others2'>&nbsp".$utenti['privilegio']."</p></td>

        <td><form method='post' action='../funzioni/update_privilegi.php'>
        <input type='hidden' name='socio' value=$socio>
        <p class='others3'><input type='submit' value='Privilegio 1►2'></p>
        </form>
        </td>

        </tr>";
      }
      echo "</table><br>";
    }
    ?>
  </BODY>
</HTML>
