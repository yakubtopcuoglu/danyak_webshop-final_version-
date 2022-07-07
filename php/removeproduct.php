<?php
    
    session_start();

    $deletefromcart=0;
    if(isset($_GET['rid']))
    {
        $deletefromcart = $_GET['rid'];
    }

    if($deletefromcart>0)
    {
        include 'dbsettings.php';

        //Verbindung zur Datenbank
        $conn = new PDO("mysql:host=localhost;dbname=".$dbDatabasename,$dbLoginUsername,$dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->prepare("DELETE FROM shoppingcart WHERE productID=? AND email='$_SESSION[email]'")->execute([$deletefromcart]);

        //Verbindung schließen
        $conn=null;
    }


    header("Location: shoppingcart.php");

?>