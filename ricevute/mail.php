<?php
include "lib/db_login_connect.php";
$filename = 'ricevuta.pdf';
$path = 'ricevutePDF';
$file = $path . '/' . $filename;

$nome_mittente = "Francesco Sanzone";
$mail_mittente = "sanzo95@hotmail.com";/*Inserire l'indirizzo email che verrà visualizzato come mittente dell'email*/
$mail_destinatario = "sanzone95@gmail.com";

$mail_oggetto = 'Ricevuta di prova';

$mail_corpo="<HTML>
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

$content = file_get_contents($file);
$content = chunk_split(base64_encode($content));

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (RFC)
$eol = '\r\n';

// main header (multipart mandatory)
$headers = 'From:'.$nome_mittente.' <'.$mail_mittente.'>'.$eol;
//$headers .= 'X-Mailer: Sismail Web Email Interface\n';
$headers .= 'Reply-To: $mail_mittente'.$eol;
$headers .= 'X-Priority: 1'.$eol;
$headers .= 'MIME-Version: 1.0'.$eol;
$headers .= 'Content-Type: multipart/mixed; boundary='.$separator.$eol;
$headers .= 'Content-Transfer-Encoding: 7bit'.$eol;
$headers .= 'This is a MIME encoded message.'.$eol;
//$headers .= 'Content-type: text/html; charset=iso-8859-1'.$eol;
//$mail_headers .= "X-attachments: $filename";

// message
$body = '--' . $separator.$eol;
$body .= 'Content-Type: text/plain; charset=iso-8859-1'.$eol;
$body .= 'Content-Transfer-Encoding: 8bit'.$eol;
$body .= $eol.$mail_corpo.$eol.$eol;

// attachment
$body .= '--'.$separator.$eol;
$body .= 'Content-Type: application/octet-stream; name='.$filename.$eol;
//$body .= 'Content-type: application/pdf; name='.$titolo.$eol;
$body .= 'Content-Transfer-Encoding: base64'.$eol;
//$body .= 'Content-Disposition: attachment'.$eol;
$body .= 'Content-disposition: attachment; filename='.$filename.$eol;
$body .= $eol.$content.$eol.$eol;
$body .= '--' . $separator . '--';

//SEND Mail
if (mail($mail_destinatario, $mail_oggetto, $body, $headers)) {
  echo 'mail send ... OK'; // or use booleans here
} else {
  echo 'mail send ... ERROR!';
  print_r( error_get_last() );
}
?>
