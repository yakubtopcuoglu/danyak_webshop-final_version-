<?php
//PHP Session starten!
session_start();
if($_SESSION['loggedin']!=1)
{
  //Sofort Logout!
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview of Products</title>

    <?php
    include 'headimport.php'
    ?>
</head>

<body>
    
    <?php
    include 'navimport.php';
    ?>
    
    <br>

    <table class="table table-hover">
        <thead style="text-align:center; vertical-align:middle">
            <tr>
                <th scope="col">Order-ID</th>
                <th scope="col">Shippingmethod</th>
                <th scope="col">Total amount</th>
                <th scope="col">Product</th>
                <th scope="col">Buy again</th>
    
             </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
    <?php

if(isset($_SESSION["loggedin"]))
{
    if($_SESSION["loggedin"]=1)
    {

        try
        {  
            //DB

            include 'dbsettings.php';

            //verbindung zur Datenbank
            $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
            //set the PDo error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //SQL Relevante info hier nur artikelnr die ins warenkorb hinzugefügt wird
            // sqlArtikelImWarenkorb: die hinzugefügten Artikeln zusammen summiert durch SUM pro ArtikelNr
            $sqlBisherigeBestellungen = ("SELECT orderID,shippingmethod,totalamount,assocProduct  FROM orders WHERE email='$_SESSION[email]' ORDER BY orderID DESC");
            $abfrage = $conn->prepare($sqlBisherigeBestellungen);
            $abfrage->execute();
            $ergebnis = $abfrage->fetchAll();

            foreach($ergebnis as $zeile){
        
                // $value++;
                echo "<tr>";
                echo "<td>".$zeile["orderID"]. "</td>";
                echo "<td>".$zeile["shippingmethod"]. "</td>";
                echo "<td>".$zeile["totalamount"]. "</td>";
                echo "<td>".$zeile["assocProduct"]. "</td>";
                echo "
                <form method=POST action=repeatOrder.php?orderID=".$zeile["orderID"]." id=erneuteBestellungForm class=form-horizontal role=form>
                    <td>
                        <button type=submit class=btn btn-success>
                        <i class='fa-solid fa-rotate'></i>
                        </button>
                        </td>
                </form>";
                echo"</tr>";
        
            
            }
        echo"</tfoot> </table>";
            
        $conn = null;
        }

        catch(PDOException $e)
        {
            $handle = fopen ("error_login.txt", "w");
            fwrite ($handle, $e->getMessage());
            fclose ($handle);
        }
    }else
    {
        //Da nicht eingelogt ist wird auf login weitergeleitet
        header("Location: login.php");
    }

}else
{
    //Da nicht eingelogt ist wird auf artikelübersicht weitergeleitet
    header("Location: login.php");
}   

?>

    <?php
    include 'footimport.php';
    ?>


    </body>
</html>