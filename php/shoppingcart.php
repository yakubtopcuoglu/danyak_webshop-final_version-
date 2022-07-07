<?php

//PHP Session starten!
session_start();

if($_SESSION["login"] != 111)
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
    <title>Shopping Cart</title>

    <?php
    include 'headimport.php';
    ?>

</head>
<body>

    <?php
        include 'navimport.php';
    ?>

    <br>

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
      $sql = "SELECT * FROM shoppingcart sc INNER JOIN product p ON p.id = sc.productID AND email = '$_SESSION[email]' " ;
      $query = $conn->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      $value =0;

    //   $sql2 ="SELECT COUNT(email) as orderperemail FROM shoppingcart sc INNER JOIN product p ON p.id = sc.productID AND email = '$_SESSION[email]'";
    //   $query2 = $conn->prepare($sql2);
    //   $query2->execute();
    //   $result2 = $query2-> fetchAll();

      //total price variable
      $gesamtsumme=0;
      $gerundetgesamtsumme = 0;

      //Product in Shopping cart
      foreach($result as $row)
      {
        $value++;
        $discountlabel="0% discount";
        $color="white";

                // Discount Calculation
                if($row["amount"]>=16)
                {
                    $discount = $row["price"] * 0.84;
                    $positionvalue = round($discount * $row["amount"],2);
                    $gesamtsumme += $positionvalue;
                    $discountlabel="16% discount";
                    $color="red";
                }
                else if ($row["amount"]>=8 && $row["amount"]<16)
                {
                    $discount = $row["price"] * 0.92;
                    $positionvalue = round($discount * $row["amount"],2);
                    $gesamtsumme += $positionvalue;
                    $discountlabel="8% discount";
                    $color="red";
                }
                else
                {
                    $positionvalue = round($row["amount"]*$row["price"],2);
                    $gesamtsumme += $positionvalue;
                }  

        echo '<section class="h-100" style="background-color: white;">
            <div class="container h-100" style="padding-right:0px;padding-left:0px">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12">
                        <div class="card rounded-3 mb-4" style="background-color: white;">
                            <div class="card-body p-2">
                                <div class="row d-flex justify-content-between align-items-center">
                                    
                                    <div class="col-md-2 col-lg-2 col-xl-2">
                                        <img src='.$row["photo"].' class="img-fluid rounded-3" alt="product photo">
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xl-3">
                                        <p class="lead fw-normal mb-2">'.$row["name"].'</p>
                                        <p class="text-muted">'.$row["category"].'<br> On Stock: '.$row["stock"].'</p>
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xl-2 d-flex">

                                        <a href="setamountminus.php?mid='.$row['productID'].'"
                                            <button class="btn btn-link px-2">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </a>

                                        <form method="post" action="changecart.php">
                                        <input id="'.$row["id"].'" type="number" value="'.$row["amount"].'" min="0" max="'.$row["stock"].'" name="newamount">
                                        <button type="submit" id="button_change" hidden value="'.$row['id'].'" name="changeID" class="btn btn-info">Change Amount</button></form>

                                            <a href="setamountplus.php?pid='.$row['productID'].'&pamount='.$row["amount"].'&pstock='.$row["stock"].'"
                                                <button class="btn btn-link px-2">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </a>
                                    </div>

                                    <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                        <h6 class="mb-0"  style="text-align:center"><span class="text-muted">Amount: '.$row["amount"].'</h6><h6 style="text-align:right">Price per item: '.$row["price"].'€ </span><br>Subtotal: '.$positionvalue.'€</h6><p style="text-align: right; color:'.$color.'">'.$discountlabel.'</p>
                                    </div>

                                    <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                        <a href="removeproduct.php?rid='.$row['productID'].'" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>'; 

        $setpositionvalue=("UPDATE shoppingcart SET positionvalue = '$positionvalue' WHERE email = '$_SESSION[email]' AND productID = '".$row["productID"]."'");
        $query2 = $conn->prepare($setpositionvalue);
        $query2->execute();




        } //Ende for each

        $gerundetgesamtsumme = round($gesamtsumme,2);

    //   // Coupon Block
    //   echo'
    //   <div class="card mb-4">
    //       <div class="card-body p-4 d-flex flex-row">
    //         <div class="form-outline flex-fill">
    //           <input type="text" id="form1" class="form-control form-control-lg" />
    //           <label class="form-label" for="form1">Discount code</label>
    //         </div>
    //         <button type="button" class="btn btn-outline-warning btn-lg ms-3">Apply</button>
    //       </div>
    //     </div>';

        //Total price
        $sqlcartcheck= "SELECT count(*) FROM shoppingcart WHERE email = '$_SESSION[email]'";
        $query3 = $conn->prepare($sqlcartcheck);
        $query3->execute();
        $result3 = $query3->fetchColumn();
        if($result3 > 0){
        echo'
        <div class="card text-center">
            <div class="card-body">';
                echo 'Total price: '.$gerundetgesamtsumme;
                $_SESSION["gesamtsumme"] = $gerundetgesamtsumme;
        echo'</div>
        </div>
        ';
        
        //Proceed to Pay
        echo'
        <form method="POST" action="order.php?gerundetgesamtsumme" id="bestellungform">
            <div class="card text-center">
                <div class="card-body">
                        <button type="submit" id=paybutton name="totalprice" value="'.$gerundetgesamtsumme.'"  class="btn btn-warning btn-block btn-lg" >Proceed to Pay</button>
                </div>
            </div>
        </form>';
        } else{
            echo "<h3 style='text-align:center'>Shopping cart is empty right now</h3>";
        }
        $_SESSION["totalprice"]= $gerundetgesamtsumme;
    //echo gettype($gerundetgesamtsumme);
      $conn = null;
  }
      catch(PDOException $e)
      {
          $handle = fopen ("error_login.txt", "w");
          fwrite ($handle, $e->getMessage());
          fclose ($handle);
      }
?>



<?php
      include 'footimport.php';
    ?>
<!-- Funktioniert nicht... -->
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

<script>
    document.getElementById('#paybutton').disabled = false;
</script>
</body>
</html>