<?php
include('../lib/db_login_connect.php');
include('../lib/lock2.php');
?>

<HTML>
  <HEAD>
    <TITLE>Ricevute emesse</TITLE>
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />  <!-- css per lo stile della pagina -->
    <style>
    p.title { /*Stile aggiuntivo per questa pagina*/
      font: 20px helvetica, sans-serif;
      font-weight: bold;
    }
    p.others2 {
      font: 16px helvetica, sans-serif;
      top: 50%;
      left: 50%;
      right: 50%;
      align-content: center;
      align-items: center;
      align-self: center;
      line-height: 15px; /* verticale */
    }
    </style>


  </HEAD>
  <BODY>

    <?php
    $codiceSocioEmittente=$_SESSION['cod'];
    $elenco= mysqli_query($mysqli, "SELECT cognome, nome, mailDestinatario, DATE_FORMAT(dataEmissione, '%d/%m/%Y') as dataEmissione,
    importo, causale, file FROM ricevute WHERE codiceSocioEmittente = $codiceSocioEmittente AND stato = 'emessa' ORDER BY ID ASC");


    if (($elenco->num_rows) != 0){
      echo "<p class='title'>Ricevute emesse:</p><br>";
      echo "
      <table border=1><tr align='center' valign='middle'>
      <td valign='middle' align='center' nowrap ><p class='others2'><b>&nbsp&nbspCognome&nbsp&nbsp</p></td>
      <td valign='middle' nowrap><p class='others2'><b>&nbsp&nbspNome&nbsp&nbsp</p></td>
      <td valign='middle' nowrap><p class='others2'><b>&nbsp&nbspMail&nbsp&nbsp</p></td>
      <td valign='middle' nowrap><p class='others2'><b>&nbsp&nbspData Emissione&nbsp&nbsp</p></td>
      <td valign='middle' nowrap><p class='others2'><b>&nbsp&nbspImporto&nbsp&nbsp</p></td>
      <td valign='middle' nowrap><p class='others2'><b>&nbsp&nbspCausale&nbsp&nbsp</p></td>
      </tr>";
      while($ricevuta = mysqli_fetch_array($elenco)){
        $file= $ricevuta['file'];

        $cognomeSocio = $ricevuta['cognome'];
        $nomeSocio = $ricevuta['nome'];
        $mailDestinatario = $ricevuta['mailDestinatario'];
        $dataEmissione = $ricevuta['dataEmissione'];
        $importo= $ricevuta['importo'];
        $causale= $ricevuta['causale'];
        echo "<tr>
        <td ><p class='others2'>&nbsp".$cognomeSocio."&nbsp</p></td>
        <td ><p class='others2'>&nbsp".$nomeSocio."&nbsp</p></td>
        <td ><p class='others2'>&nbsp".$mailDestinatario."&nbsp</p></td>
        <td align='center' nowrap><p class='others2'>&nbsp".$dataEmissione."&nbsp</p></td>
        <td align='center' nowrap><p class='others2'>&nbsp".$importo."&nbsp</p></td>
        <td ><p class='others2'>&nbsp".$causale."&nbsp</p></td>

        <td width=100>
        <form method='post'>
        <input type='hidden' name='file' value=$file>";
        //chiedere conferma del tasto cliccato
        echo "
        <p></p><p class='others2' style='text-align: center'>&nbsp<input  type='submit' formaction='../dash/index.php?s=3' value='Invia Mail'>&nbsp</p></td>
        </form>
        </td>

        <td width=100>
        <form method='post'>";
        $download='si';
        echo "<input type='hidden' name='file' value=$file>
        <input type='hidden' name='download' value=$download>
        <p></p><p class='others2' style='text-align: center'>&nbsp<input type='submit' formaction='../funzioni/generaPDF.php' value='Download'>&nbsp</p>
        </form>
        </td>";

        if(isset($_SESSION['privilegio'])? $_SESSION['privilegio']>=3 : false ){
          echo "
          <td width=100>
          <form method='post'>";
          $stato='annullata';
          echo "<input type='hidden' name='file' value=$file>
          <input type='hidden' name='stato' value=$stato>
          <p></p><p class='others2' style='text-align: center'>&nbsp<input type='submit' formaction='../funzioni/annulla_ricevuta.php' value='Elimina'>&nbsp</p>
          </form>
          </td>
          ";
        }
        echo "</tr>";
      }
      echo "</table><br>";
    }else{
      echo "<p class='others2' style='text-align: center'><h3>Nessuna ricevuta emessa</h3>";
    }
    ?>

  </BODY>
</HTML>
