<?php
session_start();
$sEmail="";
if (isset($_POST['email']))
{
    $sEmail=$_POST['email'];
}
try
{

    //DB
    include 'dbsettings.php';
    //verbindung zur datenbank
    $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
    //set the PDo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //SQL
    $result=$conn->prepare("SELECT COUNT(email) as EmailExists FROM ws_login WHERE email =$sEmail");
    $result->execute();
    $ergebnis = $result->fetchAll(); 
    
    foreach($ergebnis as $row){
        (int)$checkEmail=$row["EmailExists"];
    }
    if($checkEmail==1){
        echo"User with this email already registered!";
    }else{
        echo"Email is OK";
    }
    
    $conn = null;
}
    catch(PDOException $e)
    {
        $handle = fopen ("error_login.txt", "w");
        fwrite ($handle, $e->getMessage());
        fclose ($handle);
    }











?>