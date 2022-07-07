<?php

//PHP Session starten!
session_start();

if($_SESSION["login"] != 111)
{
  //Sofort Logout!
  header("Location: login.php");
}

if(isset($_POST['newamount']))
    {
        $newAmount = $_POST['newamount'];
        $changeID = $_POST['changeID'];
    }

    include 'dbsettings.php';

    //Verbindung zur Datenbank
    $conn = new PDO("mysql:host=localhost;dbname=".$dbDatabasename,$dbLoginUsername,$dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if($newAmount>0)
    {

            $sql = "UPDATE shoppingcart SET amount = $newAmount WHERE productID=? AND email = '$_SESSION[email]'";
            $stmt = $conn->prepare($sql);
            $stmt -> execute([$changeID]);

        //Verbindung schließen
        $conn=null;
    } elseif($newAmount==0){

        $sql0 = "DELETE FROM shoppingcart WHERE productID=? AND email = '$_SESSION[email]'";
            $stmt0 = $conn->prepare($sql0);
            $stmt0 -> execute([$changeID]);

             //Verbindung schließen
            $conn=null;
    }

    header("Location: shoppingcart.php");

?>

