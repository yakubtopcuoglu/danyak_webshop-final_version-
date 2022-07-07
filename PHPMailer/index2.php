<?php

//Include required phpmailer files 
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

//Define name spaces 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Random PW mit Buchstaben und Zahlen erzeugen:
function randomPW()
{
    
    $options1=array('0','1','2','3','4','5','6','7','8','9');
    $options2=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    $options3=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $randomPassword='';

    for($i=0;$i<9;++$i)
    {
        $randomPassword .=$options[rand(0,35)];
    }
    return $randomPassword;
}

$bLoginSuccess=false;
$sFirstname=$_POST['firstname'];
$sSurname=$_POST['surname'];
$sEmail=$_POST['email'];
$sStreet=$_POST['str'];
$sCity=$_POST['city'];
$sZip=$_POST['zip'];
$sPassword=randomPW();
$sPasswordHash = hash('sha512',$sPassword);


// ------E-Mail Einstellungen--------


    //Create instance of phpmailer
    $mail = new PHPMailer();
    //Enable verbose debug output
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    //Set mailer to use smtp
    $mail->isSMTP();
    //define smtp host
    $mail->Host = "smtp.gmail.com";
    //enable smtp authentication
    $mail->SMTPAuth = "true";
    //set type of encryption (ssl/tls)
    $mail->SMTPSecure = "tls";
    //set port to connect smtp
    $mail->Port = "587";
    //set gmail username
    $mail->Username = "yakubtopcuoglu96@gmail.com";
    //set gmail password
    $mail->Password = "xsxmcgbchjmrqpyf";
    //Set email format to HTML
    $mail->isHTML(true);
    //set sender email
    $mail->setFrom("yakubtopcuoglu96@gmail.com", "Danyak-Shop");
    //set email subject
    $mail->Subject = "Thanks for registration at Danyak Shop! First Login ";
    //email body
    $mail->Body = 'Hello <b>'.$sFirstname.'</b>,
                  <p> Your password is: <b>'.$sPassword.'</b>. </p>
                  <p> You should set your own password when you first log in.</p> <br>
                  <p> Best regards </p>
                  <p> Danyak-Shop </p> ' ;
    //Add recipient
    $mail->addAddress($sEmail);
    //Finally send email
   
    try
    {
  
        // ------DB Einstellungen-------
        //DB
        include '../php/dbsettings.php';
        //verbindung zur datenbank
        $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
        //set the PDo error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        //SQL
        $sqlNewUser = "INSERT INTO ws_login (firstname,surname,pin,email,street,city,zip)
        VALUES(?,?,?,?,?,?,?)";
        // $bLoginSuccsess=true;
        $stmt=$conn->prepare($sqlNewUser);
        $stmt->execute([$sFirstname,$sSurname,$sPasswordHash,$sEmail,$sStreet,$sCity,$sZip]);

        //close connection
        $conn = null;
        $bLoginSuccess=true;
        
        if($mail->send())
        {

            echo 'Email was sent successfull!';
            header( "refresh:1;url=../php/login.php" ); 
            // header('Location: login.php');
        }else{
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

    }
    catch(PDOException $e)
    {
        $bLoginSuccess=false;
        echo( ausgabe($e->getMessage()));
        header( "refresh:3;url=registration.php" );
    }


    // if ($mail->Send() ) {
    //     echo "Schauen sie in Ihre E-Mails!";
    // }
    // else {
    //     echo "Da hat etwas leider nicht geklappt!";
    //}
//Closing smtp connection
    $mail->smtpClose();

    
?>