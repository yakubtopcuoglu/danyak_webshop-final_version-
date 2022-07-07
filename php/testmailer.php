<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP SMPT Mailer</title>
</head>
<body>
    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require '..\PHPMailer\PHPMailer/src/Exception.php';
    require '..\PHPMailer\PHPMailer/src/PHPMailer.php';
    require '..\PHPMailer\PHPMailer/src/SMTP.php';
    if(isset($_POST["submit"]))
    {
        $mail =new PHPMailer();
        $mail -> isSMTP();
        $mail -> SMTPDebug = SMTP::DEBUG_SERVER;
        $mail -> Host = "smtp.gmail.com";
        $mail -> SMTPAuth = true;
        $mail -> Username = "yakubtopcuoglu96@gmail.com";
        $mail -> Password = "YT.ETyyk1996";
        $mail -> setFrom("yakubtopcuoglu96@gmail.com", "Test1");
        $mail -> addAddress("cilgindenizci48@gmail.com");
        $mail -> isHTML(true);
        $mail -> Port = 587;
        $mail -> SMTPSecure = 'tls';
        $mail -> Subject = "Test";
        $mail -> Body = $_POST["msg"];
        
        if($mail->send())
        {
            echo "Deine Email wurde erfolgreich verschickt";
        }
        else 
        {
            echo "Es gab einen Fehler ".$mail->ErrorInfo;
        }
        

    }
    ?>
    <h1>PHP SMTP Mailer</h1>
    <form method="post" action="testmailer.php">
        <textarea name="msg" placeholder="Nachricht"></textarea><br>
        <button type="submit" name="submit">Senden</button>
    </form>

</body>
</html>