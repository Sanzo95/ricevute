 <?php
 session_start();
 include "../lib/db_login_connect.php";
 include "../lib/lock2.php";

 if(!isset($_POST['form']) || !isset($_SESSION['cod'])){
   die;
 }
 //la pagina non può essere avviata senza ricevere codice e password



 function sostituisci($stringa){
   $cerca=array("à","è","é","ì","ò","ù", ",");//e altri
   $sostituisci=array("a'","e'","e'","i'","o'","u'", ".");//deve corrispondere
   return str_replace($cerca,$sostituisci,$stringa);
 }
 $socioDestinatario=$_POST['codiceSocio'];
 $cognome = $_POST['cognome'];
 $nome = $_POST['nome'];
 $mailDestinatario = $_POST['mail'] ;
 $dataEmissione = $_POST['data'];
 $annoAssociativo = $_POST['anno'];
 $importo = round($_POST['importo'],2);
 $causale = sostituisci($_POST['causale']);

 //trovo numero delle ricevute emesse nell'anno
 $trovaProgressivo= mysqli_query($mysqli, "SELECT max(id) as progressivo FROM ricevute where $annoAssociativo = annoAssociativo");
 $risposta = mysqli_fetch_array($trovaProgressivo);
 //trova l'id
 $ricevuteEmesseAnno = $risposta['progressivo'] +1 ;

 //trovo numero unico e progressivo delle ricevute emesse da creazione database
 $trovaProgressivo= mysqli_query($mysqli, "SELECT max(ricevuteEmesse) as progressivo FROM ricevute");
 $risposta = mysqli_fetch_array($trovaProgressivo);
 //crea il numero sequenziale per l'ultima ricevuta emessa
 $ricevuteEmesse = $risposta['progressivo'] +1 ;

//inizialmente non sempre $anno veniva stampato correttamente.
 //$file = 'ricevuta_'.$ricevuteEmesseAnno.'.pdf';
 $file = "ricevuta_Anno".$annoAssociativo."_n".$ricevuteEmesseAnno.".pdf";

 if ($insert_query_ricevute = $mysqli->prepare("INSERT INTO ricevute (annoAssociativo,ricevuteEmesse, codiceSocioEmittente, codiceSocioDestinatario, nome, cognome,
   mailDestinatario, dataEmissione,  importo, causale, file)
   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
     $insert_query_ricevute->bind_param('iiiissssdss', $annoAssociativo, $ricevuteEmesse, $_SESSION['cod'], $socioDestinatario, $nome, $cognome,
     $mailDestinatario, $dataEmissione,  $importo, $causale, $file);

     $insert_query_ricevute->execute(); //Dopo aver preparato la query con i dati ricevuti dal form, la eseguo per riempire la tabella dei dati dei soci

     //inizialmente non sempre $anno veniva stampato correttamente. così si.
/*   $trovaAnnoAssociativo= mysqli_query($mysqli, "SELECT annoAssociativo FROM ricevute where ricevuteEmesse = $ricevuteEmesse");
     $risposta = mysqli_fetch_array($trovaAnnoAssociativo);
     $anno = $risposta['annoAssociativo'] ;

     $file = "ricevuta_".$anno."_".$ricevuteEmesseAnno.".pdf";

     $setFile= mysqli_query($mysqli, "UPDATE ricevute SET file = '$file' where ricevuteEmesse = $ricevuteEmesse ");
*/
    echo '<script language=javascript>document.location.href="generaPDF.php?file='.$file.'"</script>'; //Torno alla dashboard

   }
 ?>
