<?php
// Recuperiamo i valori dal form e aggiungiamo la nostra email dove ricevere il file allegato con la mail
$mess="<HTML>

<HEAD>
<META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
<STYLE>
H5 {text-align: justify; text-decoration: none; color: #333333; font-size: 12px; font-family: Arial}
A:link, A:visited, A:hover { color: #FFcc00 }
</STYLE>

</HEAD>

<BODY bgColor=#ffffff link=#333333 alink=#333333 vlink=#333333>
<DIV>
<h5>Ciao! Invio in allegato la ricevuta n. *** di CodiceSocio.</h5>
</div>
</BODY>

</HTML>";

/*Nella variabile $mess va inserito tutto il codice html che comporrà il corpo dell'email che si vuole inviare. Come nell'esempio si possono utilizzare anche i fogli di stile.*/
$mittente= "sanzone95@gmail.com"; /*Inserire l'indirizzo email che verrà visualizzato come mittente dell'email*/
$reply="sanzo95@hotmail.it"; /*Inserire l'indirizzo email a cui verranno inviate le risposte all'email inviata*/
$e="sanzone95@gmail.com"; //destinatario
$ogg="Ricevuta n. ***"; /*Inserire l'oggetto dell'email da spedire*/

$titolo="ricevuta.pdf"; /*Inserire il nome che si vuole dare all'allegato*/
$f="ricevutePDF/".$titolo; /*Inserire l'indirizzo del file che si vuole inviare come allegato*/
$filetype="application/pdf"; /*Inserire il formato MIME del file da allegare*/



/*Non modificare nulla al di sotto di questa linea*/
$intestazioni = "From: $mittente\nReply-To: $reply\nX-Mailer: Sismail Web Email Interface\nMIME-version: 1.0\n
                 Content-type: multipart/mixed;\n boundary=\"Message-Boundary\"\nContent-transfer-encoding: 7BIT\n
                 X-attachments: $titolo";

$body_top = "--Message-Boundary\n";
$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
$body_top .= "Content-transfer-encoding: 7BIT\n";
$body_top .= "Content-description: Mail message body\n\n";

$msg_body = $body_top . $mess;

$filez = fopen($f, "r");
$contents = fread($filez, filesize($f));
$encoded_attach = chunk_split(base64_encode($contents));
fclose($filez);

$msg_body .= "\n\n--Message-Boundary\n";
$msg_body .= "Content-type: $filetype; name=\"$titolo\"\n";
$msg_body .= "Content-Transfer-Encoding: BASE64\n";
$msg_body .= "Content-disposition: attachment; filename=\"$titolo\"\n\n";
$msg_body .= "$encoded_attach\n";
$msg_body .= "--Message-Boundary--\n";

if(!(@mail($e,$ogg,$msg_body, $intestazioni))){
  print "<H5>Invio della email fallito.</H5>";
}
?>
