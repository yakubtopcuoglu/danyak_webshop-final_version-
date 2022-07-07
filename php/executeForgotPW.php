<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/includes/PHPMailer.php';
require '../PHPMailer/includes/SMTP.php';
require '../PHPMailer/includes/Exception.php';
$iChecker="";

if (isset($_POST['forgotPWEmail']))
{
    $sforgotPWEmail=$_POST['forgotPWEmail'];
    
}

try
{   
    //DB
    include 'dbsettings.php';
    //verbindung zur datenbank
    $conn = new PDO("mysql:host=localhost;dbname=".$dbDatabasename,$dbLoginUsername,$dbPassword);
    //set the PDo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL prüfen ob diese Email überhaupt in der DB vorhanden ist
    $result=$conn->prepare("SELECT *, COUNT(email) as EmailExists FROM ws_login WHERE email='$sforgotPWEmail'");

    $result->execute();
    $ergebnis = $result->fetchAll(); 

    foreach($ergebnis as $zeile)
    {
        (int)$pruefeEmail=$zeile["EmailExists"];
        $sFirstname=$zeile["firstname"];
        $_SESSION["pwVergessen"]=$zeile["EmailExists"];
    }

    //echo $pruefeEmail;

    if($pruefeEmail==1)
    {
        //header( "Location: login.php" );

        // Random PW mit Buchstaben und Zahlen erzeugen:
        function randomPW()
        {   
            $digits    = array_flip(range('0', '9'));
            $lowercase = array_flip(range('a', 'z'));
            $uppercase = array_flip(range('A', 'Z')); 
            //$special   = array_flip(str_split('!@#$%^&*()_+=-}{[}]\|;:<>?/'));
            $combined  = array_merge($digits, $lowercase, $uppercase);

            $randompassword  = str_shuffle(array_rand($digits) .
                               array_rand($lowercase) .
                               array_rand($uppercase) .  
                               implode(array_rand($combined, rand(9, 12))));

            return $randompassword;

            // $options=array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
            // $randomPassword='';
            // for($i=0;$i<9;++$i)
            // {
            //     $randomPassword .=$options[rand(0,35)];
            // }
            // return $randomPassword;
        }

        $sPassword=randomPW();
        $sPasswordHash = hash('sha512',$sPassword);
        $sqlUpdatePassword="UPDATE ws_login SET pin='$sPasswordHash' WHERE email='$sforgotPWEmail'";

        $abfrage = $conn->prepare($sqlUpdatePassword);
        $abfrage->execute();

        $sqlUpdateEmailBestaetigt="UPDATE ws_login SET emailconfirmed='no' WHERE email='$sforgotPWEmail'";
        $abfrageEmailBstgt = $conn->prepare($sqlUpdateEmailBestaetigt);
        $abfrageEmailBstgt->execute();

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
        $mail->Subject = "Your New Password ";
        //email body
        $mail->Body = 'Hello <b>'.$sFirstname.'</b>,
                    <p> Your password is: </p>
                    <p> <b>'.$sPassword.'</b> </p>
                    <p> You should set your own password when you log in.</p> <br>
                    <p> Best regards </p>
                    <p> Danyak-Shop </p> ' ;
        //Add recipient
        $mail->addAddress($sforgotPWEmail);
        //Finally send email

        if($mail->send())
        {

            echo 'Email was sent successfull!';
            header( "refresh:1;url=login.php" ); 
            // header('Location: login.php');
        }else
        {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

        
    }
    else
    {
        header( "refresh:1;url=login.php" ); 
        echo"
        <script>
        alert('So ein Account ist nicht vorhanden');
        </script>";
        
    }
    $conn = null;
}
catch(PDOException $e)
{
    $handle = fopen ("error_login.txt", "w");
    fwrite ($handle, $e->getMessage());
    fclose ($handle);
}
