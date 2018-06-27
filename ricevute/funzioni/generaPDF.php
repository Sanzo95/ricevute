<?php
session_start();
require('../lib/fpdf.php');
include('../lib/db_login_connect.php');
include('../lib/lock2.php');
date("d/m/Y");

if(!isset($_GET['file']) && !isset($_POST['file'])) {
  echo "die";
  die;
}else{
  if(isset($_GET['file'])){
    //la funzione "genera ricevuta" passa il nome tramite get
    $filename = $_GET['file'];
  }else{
    //dalla pagina visualizza ricevute si riceve il nome del file tramite metodo $_post  per il download
    $filename = $_POST['file'];
    $percorso = "../ricevutePDF/";
    if(isset($_POST['download'])){
      if($_POST['download'] ==='si'){
        header("Content-type:application/pdf");
        header('Content-Disposition: attachment; filename=' . $filename);
        readfile( $percorso.$filename );
        //$pdf->Output($percorso,'d');
        echo '<script language=javascript>document.location.href="../dash/index.php?s=3"</script>';
        die;
      }
    }
  }
}

class PDF extends FPDF
{
  // Page header
  function Header()
  {
    // Logo
    $this->Image('../ricevutePDF/intestazione.png',50,4,125, 'c');
    $this->Ln(30);
  }

  // Page footer
  function Footer()
  {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    //$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    //cambiare con numero ricevuta
  }
}

$percorso = "../ricevutePDF/"; // full path like C:/xampp/htdocs/file/file/

$trovaRicevuta= mysqli_query($mysqli, "SELECT ID, annoAssociativo, DATE_FORMAT(dataEmissione, '%d/%m/%Y') as dataEmissione
                                       FROM ricevute WHERE file = '$filename'");
$risposta = mysqli_fetch_array($trovaRicevuta);
//trova il numero di ricevuta
$numero = $risposta['ID'] ;
//trova la data di emissione
$annoAssociativo = $risposta['annoAssociativo'] ;
//trova la data di emissione
$dataEmissione = $risposta['dataEmissione'] ;

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

//stampa riga vuota per dividere da intestazione
$pdf->Cell(0,10,'',0,1);
//stampa n ricevuta
$pdf->Cell(0,10,'Ricevuta n. '.$numero.' Emessa il giorno '.$dataEmissione,0,1);
//salva il documento nell'indirizzo indicato
$pdf->Output($percorso.$filename,'f');
//file_put_contents($percorso, $pdf);

//Output the document
/*
I: send the file inline to the browser. The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
D: send to the browser and force a file download with the name given by name.
F: save to a local file with the name given by name (may include a path).
S: return the document as a string. name is ignored.
*/

echo '<script language=javascript>document.location.href="../dash/index.php?s=3"</script>';

?>
