<?php

    session_start();

    if($_SESSION['loggedin']!=1)
  {
    //Sofort Logout!
    header("Refresh:3; url: login.php");
  }

    $sNewPassword="";
    $sNewPasswordRepeat="";
    $sPasswordHash="";
    $sEmailConfirmed="yes";
    if(isset($_POST['tfNewPw']))
{
    $sNewPassword=$_POST['tfNewPw'];
}
if(isset($_POST['tfNewPwRepeat']))
{
    $sNewPasswordRepeat=$_POST['tfNewPwRepeat'];
}

if($sNewPassword==$sNewPasswordRepeat){
    $sPasswordHash = hash('sha512',$sNewPassword);
    try
    {
        //DB
        include 'dbsettings.php';

        //verbindung zur datenbank
        $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);

        //set the PDo error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //SQL
        $sqlUpdatePassword ="UPDATE ws_login SET pin=? , emailconfirmed=?  WHERE email=?";
        $stmt=$conn->prepare($sqlUpdatePassword);
        $stmt->execute([$sPasswordHash,$sEmailConfirmed,$_SESSION["email"]]);
        
        
        $conn = null;
    }
    catch(PDOException $e)
    {
        $handle = fopen ("error_updatePassword.txt", "w");
        fwrite ($handle, $e->getMessage());
        fclose ($handle);
    }
    //echo "test";
    header("Location: login.php");
}else{
//echo "Password does not match";
header("Location: newPW.php");


}



?>