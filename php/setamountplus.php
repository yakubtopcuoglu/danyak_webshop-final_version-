<?php
    
    $setplus=0;
    if(isset($_GET['pid']))
    {
        $setplus = $_GET['pid'];

        if(isset($_GET['pamount']))
        {
            $amount = $_GET['pamount'];

            if(isset($_GET['pstock']))
            {
                $stock = $_GET['pstock'];
            }
        }
    }



    
    if($amount < $stock)
    {
        include 'dbsettings.php';

        //Verbindung zur Datenbank
        $conn = new PDO("mysql:host=localhost;dbname=".$dbDatabasename,$dbLoginUsername,$dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->prepare("UPDATE shoppingcart SET amount = amount+1 WHERE productID=?")->execute([$setplus]);

        //Verbindung schließen
        $conn=null;
    }

    header("Location: shoppingcart.php");



?>