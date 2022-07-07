<?php

include 'headimport.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/includes/PHPMailer.php';
require '../PHPMailer/includes/SMTP.php';
require '../PHPMailer/includes/Exception.php';

session_start();
if(isset($_SESSION["login"]))
{
    if($_SESSION["login"]!=111)
    {
      header("Location: login.php");
    }
}

$sFirstname = $_SESSION["firstname"];
$sEmail= $_SESSION["email"];
$orderID=$_GET["orderID"];

try
// erneute Bestellung in Datenbank Tabelle bestellung hinzufügen und an Oberfläche wiedergeben 
{   
    //DB
    include 'dbsettings.php';
    //verbindung zur datenbank
    $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
    //set the PDo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //SQL Relevante info hier nur artikelnr die ins warenkorb hinzugefügt wird
    // sqlArtikelImWarenkorb: die hinzugefügten Artikeln zusammen summiert durch SUM pro ArtikelNr
    $sqlBestellungWiederholen = ("SELECT orderID,shippingmethod,totalamount,assocProduct  FROM orders WHERE email='$sEmail' AND orderID='$orderID'");
    $abfrage = $conn->prepare($sqlBestellungWiederholen);
    $abfrage->execute();
    $ergebnis = $abfrage->fetchAll();

    foreach($ergebnis as $zeile)
    {
    
        $versandart=$zeile["shippingmethod"];
        $gesamtsumme=$zeile["totalamount"];
        $assocArtikel=$zeile["assocProduct"];
    }

    $sqlBestellungErneutHinzufuegen= "INSERT INTO orders (email,shippingmethod,totalamount,assocProduct)
    VALUES(?,?,?,?)";
    $_SESSION["sShippingMethod"]=$versandart;
    $_SESSION["sTotalamount"]=$gesamtsumme;
    $_SESSION["sAssocProduct"]=$assocArtikel;
    $stmt=$conn->prepare($sqlBestellungErneutHinzufuegen);
    $stmt->execute([$_SESSION["email"],$versandart,$gesamtsumme,$assocArtikel]);
    
    //close connection
    $conn = null;



echo 

' <!DOCTYPE html>
<html>
<head>
<title>Repeat order</title>
<meta charset=utf-8>
<!-- Bootstrap -->

</head>
<body>
<div style=text-align:center> </div>
<h2 style=vertical-align:middle >Thanks '.$_SESSION["firstname"].'! You ordered with the order-ID: '.$orderID.' again. You will get the bill per Email!</h2>
<br>
You will now be redirected...
</body>
</html>'; 

 header( "refresh:3; url = repeatOrderMail.php" ); 
// erneute Bestellung als Mail senden-----------------
}catch(PDOException $e)
{
    $handle = fopen ("error_login.txt", "w");
    fwrite ($handle, $e->getMessage());
    fclose ($handle);
}



?>
