<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_ricevute";

$mysqli = new mysqli($servername, $username, $password, $dbname); //Creo la connessione

if ($mysqli->connect_error) { //Controllo la connessione e restituisco un errore se questa non è presente
    die("Connection failed: " . $conn->connect_error);
}
?>
