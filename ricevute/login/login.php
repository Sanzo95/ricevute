<?php
include '../lib/config.php';
session_start();
if (isset($_SESSION['cod'])) {
  echo "<h1>Sei già loggato. Clicca <a href='../dash/index.php'><font color='blue'>qui</font></a> per tornare alla Dashboard.</h1>";
  die;
}
?>
<html>
<head>
  <title>Login</title>
  <link href="../css/admin.css" rel="stylesheet" type="text/css" />  <!-- css per lo stile della pagina -->
  <style> /*stile aggiuntivo per la pagina*/
  .center {
    width: 60%;
    top: 50%;
    left: 50%;
    margin-right: -115px;
  }
  p.title {
    font: 20px helvetica, sans-serif;
    font-weight: bold;
  }
</style>

</head>
<body>
  <center>
    <form id="login" action="verifica.php" method="post"> <!-- Form per il login -->
      <p class="title">Login</p>
      <fieldset id="inputs"><br>
        <input id="codiceSocio" name="codiceSocio" type="text" placeholder="Codice Socio (censimento)" autofocus required>
        <input id="password" name="password" type="password" placeholder="Password" required>
      </fieldset>
      <div class="center">
        <fieldset id="actions">
          <input type="submit" id="submit" value="Accesso">
        </form>
   <form id="register" action='../forms/register_newUtente.php'>
          <input type='submit' id='submit' value='Registrazione' />
        </fieldset>
      </div>
    </form>
  </center>
</body>
</html>
