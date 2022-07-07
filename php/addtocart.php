<?php

//PHP Session starten!
session_start();

if($_SESSION["loggedin"] != 1)
{
  //Sofort Logout!
  header("Location: login.php");
}

if(isset($_POST['addamount']))
    {
        $addamount = $_POST['addamount'];
        $addtocart = $_POST['addtocart'];
    }


    if($addamount>0)
    {
        include 'dbsettings.php';

        //Verbindung zur Datenbank
        $conn = new PDO("mysql:host=localhost;dbname=".$dbDatabasename,$dbLoginUsername,$dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
        $sql = "INSERT INTO shoppingcart (email, productID, amount) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['email'],$addtocart,$addamount]);
        } catch(Exception $e){
            $sqlEx = "UPDATE shoppingcart SET amount = amount+ $addamount WHERE productID=? AND email = '$_SESSION[email]'";
            $stmtEx = $conn->prepare($sqlEx);
            $stmtEx -> execute([$addtocart]);
        }

        //Verbindung schließen
        $conn=null;
    }

    header("Location: product.php");

?>

