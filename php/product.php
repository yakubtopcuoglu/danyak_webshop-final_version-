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
    <title>Overview of Products</title>

    <?php
    include 'headimport.php'
    ?>

<!-- <script>
        var x = document.getElementById("test");
        x.addEventListener("focus", myFocusFunction, true);
        x.addEventListener("blur", myBlurFunction, true);

        function myFocusFunction() {
        document.getElementById("addamount").style.backgroundColor = "yellow";
        }

        function myBlurFunction() {
        document.getElementById("addamount").style.backgroundColor = "";
        }
</script> -->

</head>
<body>
    
    <?php
    include 'navimport.php';
    ?>
    
    <br>
    <p> If you choose a product <span style="font-weight:bold">8 times</span> , you get <span style="font-weight:bold">8% discount</span>. If you choose a product <span style="font-weight:bold">16 times</span> , you get <span style="font-weight:bold">16% discount</span>.  </p>
    <p> Enter discount code <span style="font-weight:bold">"DYSHOP15"</span> and get <span style="font-weight:bold">15% discount</span> on your order.</p>

    <table class="table table-hover">
    <thead  style="text-align:center; vertical-align:middle">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Product</th>
            <th scope="col">Category</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Shoppingcart <i class="fas fa-shopping-cart"></i></th>
        </tr>
    </thead>
    <tbody style="text-align:center; vertical-align:middle">
    <?php
    try
    {  
      //DB

      include 'dbsettings.php';

      //verbindung zur Datenbank
      $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
      //set the PDo error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
  
      //SQL
      $sql = "SELECT * FROM product";
      $query = $conn->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      $value =0;
      foreach($result as $row){
        $value++;
        echo "<tr>
        <th>".$row["id"]. "</th>
        <td style='white-space: nowrap'>".$row["name"]." <br> <img src=".$row["photo"]." class=img-thumbnail height=100 width=100></td>
        <td>".$row["category"]."</td>
        <td  style='text-align: justify'>".$row["description"]."</div>
        </div></td>
        <td style='font-weight: bold'>".$row["price"]."</td>
        <td>
        <form method='post' action='addtocart.php'>
        <p class='text-muted'><br> On Stock: ".$row["stock"]."</p>
        <input id='".$row["id"]."' type='number' value='1' min='1' max='".$row["stock"]."' name='addamount'>
        <button type='submit' id='button_add' value='".$row['id']."' name='addtocart' class='btn btn-info'>add to cart</button></form>
        </td>";

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

    <?php
    include 'footimport.php';
    ?>

<!-- <script>
        var x = document.getElementById(<?php echo $row["id"]?>);
        x.addEventListener("focus", myFocusFunction, true);
        x.addEventListener("blur", myBlurFunction, true);

        function myFocusFunction() {
        document.getElementById(<?php echo $row["id"]?>).style.backgroundColor = "yellow";
        }

        function myBlurFunction() {
        document.getElementById(<?php echo $row["id"]?>).style.backgroundColor = "";
        }
</script> -->

    </body>
</html>