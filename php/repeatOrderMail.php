<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/includes/PHPMailer.php';
require '../PHPMailer/includes/SMTP.php';
require '../PHPMailer/includes/Exception.php';

session_start();
try{


$html=
"<!DOCTYPE html>
<html>
<head>
<meta charset=UTF-8>
<title>Your order</title>

</head>
<body>
<table style='border'>
    <thead>
        <tr>
            <th scope=col>Artikelname</th>
                <td>".str_replace("Artikelname:","",$_SESSION["sAssocProduct"])."</td>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
    </tfoot>
    <div>Versandart:".$_SESSION["sShippingMethod"]."</div>
    <div><h3>Gesamtsumme:".$_SESSION["sTotalamount"]."</h3></div>
</body>
</html>
";
$mail = new PHPMailer();
// ------E-Mail Einstellungen--------
//Server settings
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;               //Enable verbose debug output
$mail->isSMTP();                                       //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                  //Set the SMTP server to send through
$mail->SMTPAuth   = true;                              //Enable SMTP authentication
$mail->Username   = 'yakubtopcuoglu96@gmail.com';      //SMTP username
$mail->Password   = 'xsxmcgbchjmrqpyf';                //SMTP password
$mail->SMTPSecure = 'tls';                             //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;                               //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
$mail->Charset = "UTF-8";
$mail->IsHTML(true);
$mailBetreff="Ihre Bestellung";
$mailText="Hallo".$_SESSION["firstname"]; 
$mailFrom="From: <test@DESKTOP-M10IQI3.de>";
//Recipients
$mail->setFrom("yakubtopcuoglu96@gmail.com", "Danyak-Shop");       // Absender
    
$mail->addAddress($_SESSION["email"]);                             //Ziel Adresse
//Content
                               
$mail->Subject = 'Order has been received';
//Add logo attachment
$mail->AddEmbeddedImage('../images/logo-danyak-mail.png','danyaklogo');


// in die Email Artikelmenge Artikelname Versand und Gesamtsumme
$mail->Body    = 'Hello <b>'.$_SESSION["firstname"].'</b>,
<p> Your order has been received. The order seen below will be shipped soon.</p>
<br>'.$html.'<br>
<br>Please transfer the total amount in 14 days';

if($mail->send())
    {
        header( "refresh:1;url=thanksOrder.php" ); 
        $_SESSION["orders"]=true;
    }else{
        echo 'Mail order could not be executed.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        $_SESSION["orders"]=false;
    }

$_SESSION["orders"]=true;

}
catch(PDOException $e){
  echo 'Message could not be sent.';
  echo 'Mailer Error: ' . $mail->ErrorInfo;
  $_SESSION["orders"]=false;
}

?>