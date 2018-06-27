<style>
p.title { /*Stile aggiuntivo per questa pagina*/
  font: 35px helvetica, sans-serif;
  font-weight: bold;
}
</style>
<?php
$privilegio =1 ;
if (isset($_SESSION['autorizzato']) && isset($_SESSION['privilegio'])) {
  if($_SESSION['autorizzato'] == 1)
  $privilegio = $_SESSION['privilegio'];
}
if ($privilegio != "2" && $privilegio != "3" && $privilegio != "4" ){
  echo "<p class='title'>Area riservata.</p>";
  die;
}
?>
