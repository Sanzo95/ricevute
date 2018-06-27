<?php
session_start();
$_SESSION = array();
session_destroy(); //Distruggo le sessioni attive
header("location: login.php");  //Ritorno alla pagina principale
