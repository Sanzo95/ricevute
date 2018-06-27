<?php
//verificare che si possa accedere solo con login da parte di un privilegio 2, 3 o 4
include('../lib/lock2.php');
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
  <p class="title">Genera ricevuta:</p>
  <form method="post" name="form" action="../funzioni/process_genera_ricevutaTerzi.php">  <!-- Form per l'invio dei dati da registrare -->
    <fieldset id="inputs">
      <p class="others">
        <table>
          <tr>
            <td>Nome:&nbsp </td>
            <td><input type="text" name="nome" placeholder="Nome" maxlength="64" required autofocus><br>
            </td>
          </tr>
          <tr>
            <td>Cognome:&nbsp </td>
            <td><input type="text" name="cognome" placeholder="Cognome" maxlength="64" required><br>
            </td>
          </tr>
          <tr>
            <td>E-Mail:&nbsp </td>
            <td><input type="email" name="mail" placeholder="Indirizzo Mail" maxlength="64" required>
            </td>
          </tr>
          <tr>
            <?php echo "<input type='hidden' name='data' value='".date('Y-m-d')."';><br>";?>
            <input type="hidden" name="anno" maxlength="4" value='<?php
            $anno= date('Y');
            $mese= date('m');
            $giorno= date('g');
            if ($giorno<='30' && $mese<='09'){
              echo $anno;
            }else {
              echo $anno+1;
            }
            ?>'>
            <td>Causale:&nbsp </td>
            <td><input  type="text" name="causale" placeholder="Causale" required><br>
            </td>
          </tr>
          <tr>
            <td>Importo:&nbsp </td>
            <td><input type="text" name="importo" placeholder="Importo (es. 10.50)" onKeyUp="onlynumber(this)" required><br>
            </td>
          </tr>
        </table></p>
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
