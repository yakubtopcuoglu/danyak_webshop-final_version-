<?php

//PHP Session starten!
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview of searched products</title>

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
            <th scope="col">ID</th>
            <th scope="col">Product</th>
            <th scope="col">Category</th>
            <th scope="col">Description</th>
            <th scope="col">Price <i class="fas fa-euro-sign"></i></th>
            <th scope="col">Shoppingcart<i class="fas fa-shopping-cart"></i></th>
        </tr>
    </thead>
  <tbody style="text-align:center; vertical-align:middle">

  <?php


    if (isset($_POST['searchProduct']))
    {
        $sProduct=$_POST['searchProduct'];
        
    }
    try
    {  
        //DB

        include 'dbsettings.php';

        //verbindung zur Datenbank
        $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
        //set the PDo error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    
        
        //SQL
        $sqlSucheArtikel = ("SELECT * FROM product WHERE name LIKE '%$sProduct%'");
        $abfrage = $conn->prepare($sqlSucheArtikel);
        $abfrage->execute();
        $ergebnis = $abfrage->fetchAll();
        
        foreach($ergebnis as $zeile){
        
        echo "<tr>
        <th>".$zeile["id"]. "</th>
            <td>".$zeile["name"]." <br> <img src=".$zeile["photo"]." class=img-thumbnail height=100 width=100></td>
            <td>".$zeile["category"]."</td>
            <td>".$zeile["description"]."</td>
            <td>".$zeile["price"]."</td>
            <td>
            <br> 
            <form method='post' action='addtocart.php'>
                <p class='text-muted'><br> On Stock: ".$zeile["stock"]."</p>
                    <input id='".$zeile["id"]."' type='number' value='1' min='1' name='addamount'>
                    <br>
                    <button type='submit' id='button_add' value='".$zeile['id']."' name='addtocart' class='btn btn-info'>add to cart
                    </button>
            </form>
        </td>
        </tr>";

        ?>
        
        <!-- Für jeden Artikel funktion ausführen -->
        <script>
            var x = document.getElementById(<?php echo $row["id"]?>);
            x.addEventListener("focus", myFocusFunction, true);
            x.addEventListener("blur", myBlurFunction, true);

            function myFocusFunction() {
            document.getElementById(<?php echo $row["id"]?>).style.backgroundColor = "yellow";
            }

            function myBlurFunction() {
            document.getElementById(<?php echo $row["id"]?>).style.backgroundColor = "";
            }
        </script>
        
        <?php
        // echo "<br>";
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
</tbody>
    </table>



  <tbody>
    <?php
    include 'footimport.php';
    ?>

    </body>
</html>