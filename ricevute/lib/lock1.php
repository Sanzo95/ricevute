<style>
p.title { /*Stile aggiuntivo per questa pagina*/
  font: 35px helvetica, sans-serif;
  font-weight: bold;
}
</style>

<?php
if(isset($_SESSION['privilegio'])){
  if($_SESSION['privilegio']==="1"){
    echo '<p class="others">La tua iscrizione è stata presa in carico dal sistema. Attendi.</p>';
  }else{
    echo '<p class="others">Seleziona una funzione dal menù a sinistra</p><br>';
  }
}else{
  $privilegio =1 ;
  if ($privilegio != "2" && $privilegio != "3" && $privilegio != "4" ){
  echo "<p class='title'>Area riservata.</p>";
    die;
  }
  die;
}


?>
