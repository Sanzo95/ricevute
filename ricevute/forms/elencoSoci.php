<?php
//verificare che si possa accedere solo con login da parte di un privilegio 3 o 4
include('../lib/lock.php');
include('../lib/db_login_connect.php');
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
    p.others2 {
      font: 16px helvetica, sans-serif;
    }
    .center {
      width: 60%;
      top: 50%;
      left: 50%;
      margin-right: -43%;
    }
    </style>


  </HEAD>
  <BODY>

    <?php
    if($_GET['s'] == 2){
      echo "<p class='title'>Genera ricevuta:</p><br>";
    }else if($_GET['s'] == 4){
      echo "<p class='title'>Gestisci soci:</p><br>";
    }else{
      //in caso di errore
      echo "<br>";
    }

    echo "
    <table border=1>
    <td><p class='others2'  align='center'><b>&nbspCodice Socio&nbsp</p></td>
    <td><p class='others2'><b>&nbsp&nbspCognome&nbsp&nbsp</p></td>
    <td><p class='others2'><b>&nbsp&nbspNome&nbsp&nbsp</p></td>";

    if($_GET['s'] == 2){
      echo "<td align='center'><p class='others2'><b>&nbspRicevuta&nbsp</p></td>";
    }else if($_GET['s'] == 4){
      echo "<td  align='center'><p class='others2'><b>&nbspModifica&nbsp</p></td>";
      if($_SESSION['privilegio'] == 4){
        echo "<td align='center'><p class='others2'><b>&nbspRimuovi&nbsp</p></td>";
      }
    }else{
      //in caso di errore
      echo "<td><p class='others2'><b>&nbsp&nbspSeleziona&nbsp&nbsp</p></td>";
    }




    $elenco = mysqli_query($mysqli, "SELECT codiceSocio, cognome, nome  FROM soci WHERE censito ='si' ORDER BY cognome ASC");

    while($socio = mysqli_fetch_array($elenco)){
      $codiceSocio=$socio['codiceSocio'];
      $cognomeSocio = $socio['cognome'];
      $nomeSocio = $socio['nome'];
      echo "<tr>
      <td><p class='others2'>&nbsp&nbsp".$codiceSocio."&nbsp&nbsp</p></td>
      <td><p class='others2'>&nbsp&nbsp".$cognomeSocio."&nbsp&nbsp</p></td>
      <td><p class='others2'>&nbsp&nbsp".$nomeSocio."&nbsp&nbsp</p></td>

      <td><form method='post'>
      <input type='hidden' name='codiceSocio' value=$codiceSocio>";
      if($_GET['s'] == 2){
        echo  "<p class='others3'>&nbsp&nbsp&nbsp<input type='submit' formaction='../dash/index.php?s=5' value='Genera'>&nbsp</p></td>";
      }else if($_GET['s'] == 4){
        echo  "<p class='others3'>&nbsp&nbsp&nbsp<input type='submit' formaction='../dash/index.php?s=6' value='Modifica'>&nbsp&nbsp&nbsp</p></td>";
        if($_SESSION['privilegio'] == 4){
          echo "<input type='hidden' name='censito' value='no'>";
          echo "<td>&nbsp&nbsp&nbsp<input type='submit' formaction='../dash/index.php?s=6' value='Non censito'>&nbsp&nbsp&nbsp</p></td>";
        }
      }else{
        //in caso di errore
        echo  "<p class='others3'>&nbsp&nbsp&nbsp<input type='submit' value='Seleziona'>&nbsp</p></td>";
      }
      echo "</form>
      </tr>";
    }
    echo "</table><br>";
    ?>

  </BODY>
</HTML>
