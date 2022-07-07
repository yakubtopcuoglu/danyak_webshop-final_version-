<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/includes/PHPMailer.php';
require '../PHPMailer/includes/SMTP.php';
require '../PHPMailer/includes/Exception.php';

$sFirstname = $_SESSION["firstname"];
$sEmail= $_SESSION["email"];
$sGesamtsumme = $_SESSION["pricewithamount"];
$sShippingCost = $_SESSION["shippingcost"];

try
{
    //DB
    include 'dbsettings.php';
    //verbindung zur datenbank
    $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
    //set the PDo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //header( "Location: product.php" );

    //SQL Relevante info hier nur artikelnr die ins warenkorb hinzugefügt wird
    // sqlArtikelImWarenkorb: die hinzugefügten Artikeln zusammen summiert durch SUM pro ArtikelNr
    $sqlArtikelImWarenkorb = ("SELECT SUM(amount) AS 'productamount', productID,email  FROM shoppingcart WHERE email='$_SESSION[email]' GROUP BY productID");
    $abfrage = $conn->prepare($sqlArtikelImWarenkorb);
    $abfrage->execute();
    $ergebnis = $abfrage->fetchAll();

    $html=
    "<!DOCTYPE html>
    <html>
    <head>
        <meta charset=UTF-8>
        <title>Your order</title>
    </head>
    <body>
    <table style='border: 1px solid'>
            <thead>
                <tr>
                    <th scope=col>Product-ID</th>
                    <th scope=col>Product</th>
                    <th scope=col>Amount</th>
                    <th scope=col>Price per item in € <i class=fas fa-euro-sign></i></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot  style='text-align:center'; 'vertical-align:middle'>
    ";

    $assocArtikelDaten="";
    $_SESSION["orders"]=true;
    
    //foreach 
    foreach($ergebnis as $zeile)
    {

        //stock bei Artikel abziehen
        $deduction = $zeile["productamount"];
        $sqlStock= ("UPDATE product SET stock = stock - $deduction WHERE id= '".$zeile['productID']."'");
        $exec = $conn->prepare($sqlStock);
        $exec->execute();

        // $value++;
        $html.= "<tr>";
        $html.= "<th>".$zeile["productID"]. "</th>";

        // SQL für die restlichen artikel info von artikel tabelle in db 
        $sqlArtikelInformationen = ("SELECT * FROM product WHERE id='".$zeile["productID"]."'");
            
        $ausführung = $conn->prepare($sqlArtikelInformationen);
        $ausführung->execute();
        $sqlausführen = $ausführung->fetchAll();
        
        foreach($sqlausführen as $i)
        {
            
            $html.= "<td>".$i["name"]."</td>";
            $html.= "<td>".$zeile["productamount"]."</td>";
            $html.= "<td>".$i["price"]."</td>";
            
        
        }

        $assocArtikelDaten.="Artikelname: ".$i["name"]." - Artikelmenge: ".$zeile["productamount"]."<br>";
        // nach Bestellvorgang wird Warenkorb geleert 
        if($_SESSION["orders"]==true){
            $artikelVonWarenkorbEntfernen = "DELETE FROM shoppingcart WHERE productID =".$zeile["productID"];
            $deleteBefehl = $conn->prepare($artikelVonWarenkorbEntfernen);
            $deleteBefehl->execute();
            $ergebnis = $deleteBefehl->fetchAll();
        }
    }
    
    // Fügt der Sende Mail die ausgewählte Versandart mit 
    if($_SESSION["versandartAuswahl"]=="6")
    {
        $html.="<div>Versandart: DPD: ".$sShippingCost." €</div>";
    }else if($_SESSION["versandartAuswahl"]=="15")
    {
        $html.="<div>Versandart: DHL: ".$sShippingCost." €</div>";
    }else if($_SESSION["versandartAuswahl"]=="33")
    {
        $html.="<div>Versandart: DHL Express: ".$sShippingCost." €</div>";
    }

    $html.="</table></body></html>";
    $mail = new PHPMailer(true);
    // ------E-Mail Einstellungen--------
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;              //Enable verbose debug output
    $mail->isSMTP();                                      //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                 //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                             //Enable SMTP authentication
    $mail->SMTPSecure = 'tls';                            //Enable TLS encryption;
    $mail->Port       = 587;                              //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->Username   = "yakubtopcuoglu96@gmail.com";     //SMTP username
    $mail->Password   = "xsxmcgbchjmrqpyf";               //SMTP password

    $mail->Charset = "UTF-8";
    $mail->IsHTML(true);                                  //Set email format to HTML
    

    $mailBetreff="Ihre Bestellung";
    $mailText="Hallo".$sFirstname; 

    //$mailFrom="From: <test@DESKTOP-M10IQI3.de>";
    //Recipients
    $mail->setFrom("yakubtopcuoglu96@gmail.com", "Danyak-Shop");       // Absender
        
    $mail->addAddress($sEmail);                                        //Ziel Adresse
    //Content
    //$getOrderID = ("SELECT orderID FROM orders WHERE id='".$zeile["productID"]."'");
    $mail->Subject = 'Order has been received';
    //Add logo attachment
    $mail->AddEmbeddedImage('../images/logo-danyak-mail.png','danyaklogo');

    // in die Email Artikelmenge Artikelname Versand und Gesamtsumme
    $mail->Body    = '
    
    <img src="cid:danyaklogo"> <br> <br> <br>
    Hello <b>'.$sFirstname.'</b>,
    <p> Your order has been received. The order seen below will be shipped soon.</p>
    <br>'.$html.'<br>
    <b><h3>Total amount: '.$sGesamtsumme.'  €</h3></b><br> 
    Please transfer the total amount in 14 days
    ';

    if($mail->send())
    {
        echo 'Your bill was sent successfull!';
        header( "refresh:1;url=thanksOrder.php" ); 
        $_SESSION["orders"]=true;
    }else{
        echo 'Mail order could not be executed.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        $_SESSION["orders"]=false;
    }






}
catch(PDOException $e)
{
    $handle = fopen ("error_login.txt", "w");
    fwrite ($handle, $e->getMessage());
    fclose ($handle);
}

try{
        
    // ------DB Einstellungen-------
    //DB

    include 'dbsettings.php';

    //verbindung zur Datenbank
    $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
    //set the PDo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $versandart=$_SESSION["versandart"];
    $sqlBestellungHinzufuegen = "INSERT INTO orders (email,shippingmethod,totalamount,assocProduct) VALUES(?,?,?,?)";
   
    $stmt=$conn->prepare($sqlBestellungHinzufuegen);
    $stmt->execute([$sEmail,$versandart,$sGesamtsumme,$assocArtikelDaten]);
    //close connection
    $conn = null;
      
      
    }
    catch(PDOException $e)
    {
        echo($e->getMessage());
    }


?>