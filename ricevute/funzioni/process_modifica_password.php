<?php
session_start();
include "../lib/db_login_connect.php";
if (!isset($_SESSION['autorizzato']) || !isset($_SESSION['cod'])) {
echo "Pagina non raggiungibile";
die;
}else{
  if(!isset($_POST['newPw'])){
    die;
  }
}

$oldPw = $_POST['oldPw'];
$newPw = $_POST['newPw'];
$codiceSocio=$_SESSION['cod'];

   $query = mysqli_query($mysqli, "SELECT * FROM utenti WHERE codiceSocio = '$codiceSocio'");
   $arraySelect=mysqli_fetch_array($query);
   $saltedOldPw=sha1($oldPw.$arraySelect['salt']);
   if($saltedOldPw===$arraySelect['password']){
     $salt = uniqid(mt_rand(1, mt_getrandmax()), true);
     $saltedNewPw=sha1($newPw.$salt);
     $update_query = $mysqli->prepare("UPDATE utenti SET password = ? , salt = ? WHERE codiceSocio = '$codiceSocio'");
     $update_query->bind_param('ss', $saltedNewPw, $salt);
     $update_query->execute();
     echo '<script type="text/javascript">alert("Password modificata.");</script>';
     echo '<script type="text/javascript">alert("Effettua nuovamente il login");</script>';
     echo '<script language=javascript>document.location.href="../login/logout.php"</script>'; //Torno alla pagina del login
   }
    else {
      echo '<script type="text/javascript">alert("Vecchia password non corretta.");</script>';
      echo '<script language=javascript>document.location.href="../dash/index.php?s=19"</script>';
    }
 ?>
