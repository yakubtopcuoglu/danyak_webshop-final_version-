<?php

//PHP Session starten!
session_start();

if($_SESSION["login"] != 111)
{
  //Sofort Logout!
  header("Location: login.php");
}
//$_SESSION["gesamtsumme"] =$_SESSION["totalprice"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview of your order</title>
    
    <style>
        input[type=checkbox] {
            margin: 0px 0px 0px 0px;
        transform: scale(1.5);
    }
    </style>
        
    <?php
    include 'headimport.php'
    ?>

    <script src="../node_modules/jquery/jquery.js"></script>
    <script type="text/javascript">
    
    $(function(){ // Wird immer beim Seitenstart ausgeführt
    $('#dpd').click(function(){ // Wenn Auswahl verändert wird reagieren wir auf .change Ereignis
        if($(this).val()!=""){ // Aufruf nur durchführen wenn eine Auswahl vorhanden ist ( also Studienart ausgewählt wurde)
            $.get("shippingmethods.php",{
                auswahl: $(this).val()},
                function(daten){
                    $('#ausgabe').html(daten);
                });
            }
        });
    });

    $(function(){ // Wird immer beim Seitenstart ausgeführt
    $('#dhl').click(function(){ // Wenn Auswahl verändert wird reagieren wir auf .click Ereignis
        if($(this).val()!=""){ // Aufruf nur durchführen wenn eine Auswahl vorhanden ist
            $.get("shippingmethods.php",{
                auswahl: $(this).val()},
                function(daten){
                    $('#ausgabe').html(daten);
                });
            }
        });
    });

    $(function(){ // Wird immer beim Seitenstart ausgeführt
    $('#dhlExpress').click(function(){ // Wenn Auswahl verändert wird reagieren wir auf .click Ereignis
        if($(this).val()!=""){ // Aufruf nur durchführen wenn eine Auswahl vorhanden ist
            $.get("shippingmethods.php",{
                auswahl: $(this).val()},
                function(daten){
                    $('#ausgabe').html(daten);
                });
            }
        });
    });
//////////////////////////////////////////////////////////////////
    $(function(){ // Wird immer beim Seitenstart ausgeführt
    $('#dpd').click(function(){ // Wenn Auswahl verändert wird reagieren wir auf .click Ereignis
        if($(this).val()!=""){ // Aufruf nur durchführen wenn eine Auswahl vorhanden ist 
            $.get("totalamount.php",{
                auswahl: $(this).val()},
                function(daten){
                    $('#ausgabeGesamt').html(daten);
                });
            }
        });
    });

    $(function(){ // Wird immer beim Seitenstart ausgeführt
        $('#dhl').click(function(){ // Wenn Auswahl verändert wird reagieren wir auf .click Ereignis
            if($(this).val()!="")
            { // Aufruf nur durchführen wenn eine Auswahl vorhanden ist 
                $.get("totalamount.php",{
                    auswahl: $(this).val()},
                    function(daten)
                    {
                        $('#ausgabeGesamt').html(daten);
                    });
            }
        });
    });

    $(function(){ // Wird immer beim Seitenstart ausgeführt
        $('#dhlExpress').click(function()
        { // Wenn Auswahl verändert wird reagieren wir auf .click Ereignis
            if($(this).val()!="")
            { // Aufruf nur durchführen wenn eine Auswahl vorhanden ist 
                $.get("totalamount.php",{
                    auswahl: $(this).val()},
                    function(daten)
                    {
                        $('#ausgabeGesamt').html(daten);
                    });
            }
        });
    });
    </script>

</head>
<body>
    
    <?php
    include 'navimport.php';
    ?>
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

    //SQL-2
?>  
    <br>

    <div class="container">
        <div class="row">
            <div class="d-flex justify-content-center"><h3>Order Summary</h3></div>
                <div class="col-4">
                <h4 class="d-flex justify-content-center align-items-center mb-3">
                        <span class="text-muted" style="text-align:center">Shipping methods </span>
                        <span class="badge badge-secondary badge-pill">3</span>
                    </h4>

                    <br>

                    <form action="shippingmethods.php">
                        <input type="radio" id="dpd" name="versandarten" value="6" required />
                        <label for="dpd"><br><img src="../images/dpd.png" class=img-thumbnail height=100 width=100 name="shippingname"> DPD - 6€ </label><br>
        
                        <input type="radio" id="dhl" name="versandarten" value="15" required/>
                        <label for="dhl"><br><img src="../images/dhl.jpg" class=img-thumbnail height=100 width=100 name="shippingname"> DHL - 15€ </label><br>

                        <input type="radio" id="dhlExpress" name="versandarten" value="33" required/>
                        <label for="dhlExpress"><br><img src="../images/dhlExpress2.png" class=img-thumbnail height=100 width=100 name="shippingname"> DHL Express - 33€ </label><br>
                    </form>
                    <br>

                    <b> Please select your preferred shipping method!  </b>
                </div>


                <div class="col-8">

                    <h4 class="d-flex justify-content-center align-items-center mb-3">
                        <span class="text-muted">Your cart</span>
                        <span class="badge badge-secondary badge-pill">3</span>
                    </h4>

                    <ul class="list-group mb-3 sticky-top">

                        <?php
                            //foreach 
                            foreach($result as $row)
                            {   
                
                                echo'
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">'.$row["name"].'</h6>
                                            <small class="text-muted">Amount: '.$row["amount"].'</small>
                                        </div>
                                        <span class="text-muted">'.$row["positionvalue"].'</span>
                                    </li>
                                ';
                            }
                        ?>
                        
                        
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-success">
                                <h6 class="my-0">Promo code</h6>
                                <small value=""><?php ?></small>
                            </div>
                            <span class="text-success"><?php
                            if(isset($_SESSION["activediscountpercent"])) 
                            {
                            echo $_SESSION["activediscountpercent"].' %'; ?></span>
                            <?php
                            }
                            else{

                            }
                            ?>

                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Product</span>
                            <strong><?php
                            if(isset($_SESSION["activediscountpercent"])) 
                            {
                                $_SESSION["totalwithdiscount"] = $_SESSION["totalprice"] * (100 - $_SESSION["activediscountpercent"]) / 100;
                                echo round($_SESSION["totalwithdiscount"],2); ?></strong>

                            <?php
                            }
                            else{
                                echo round($_SESSION["totalprice"],2); ?></strong>
                            <?php
                            }
                            ?>
                            
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Packing & Shipping</span>
                            <div id="ausgabe" style="font-weight: bold"></div>
                            
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>TOTAL (EURO)</span>
                            <div id="ausgabeGesamt" style="font-weight: bold"></div>
                            <!-- <?php
                            if(isset($_SESSION["activediscountpercent"])){
                                if($_SESSION["versandartAuswahl"]=="6")
                                {
                                    $_SESSION["shippingcost"] = 6;
                                    echo round($_SESSION["totalwithdiscount"] + 6,2);

                                }else if($_SESSION["versandartAuswahl"]=="15")
                                {
                                    $_SESSION["shippingcost"] = 15;
                                    echo round($_SESSION["totalwithdiscount"] + 15,2);
                                }

                                else if ($_GET["auswahl"]=="33"){
                                    echo round($_SESSION["totalwithdiscount"] + 33,2);
                                }
                            }
                            else
                            {
                                ?>
                                <div id="ausgabeGesamt" style="font-weight: bold"></div>
                                <?php
                            }
                            ?> -->
                        </li>
                    </ul>

                    <form class="card p-2" method="POST" id="redeemcodeblock" action="executediscount.php?discountcode">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Promo code" name="discount_code">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary">Redeem</button>
                            </div>
                        </div>
                    </form>

                
                </div>
        </div>

        <br>
        <br>
                    
                    <script>
                        $("input[name=versandarten]").on("change", function() {
                            if(this.name === "versandarten"){
                                $("input[type=checkbox]").removeAttr("disabled");
                            }
                            else{
                                $("input[type=checkbox]").prop("disabled",true);
                            }
                        });
                    </script>

        <div class="d-flex justify-content-center">

            <form method='POST' action='executeOrder.php' id='bestelldurchführungform' class='form-horizontal' role='form'>
                 
                <div>
                    <button type='submit' disabled id="bezahlen" class='btn btn-success' onclick="myFunction()"><i class='fas fa-money-check'></i> Order </button>
                    <a href="privacypolicy.php" target="_blank"><input  type="checkbox" id="datenschutz" disabled onchange="document.getElementById('bezahlen').disabled=!this.checked;"> I Agree to Privacy Policy </a>
                </div>
            </form>
        
                    
                   
                   
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> </script>

                    <script>
                        function myFunction()
                        {
                        if(document.getElementById("datenschutz").checked==true){
                            swal("Order has been received!");
                        }else{
                            swal("Please accept the privacy policy!");
                        }
                        
                        }
                    </script>
        </div>
    </div>
        

    
    <?php
    }
    catch(PDOException $e)
    {
        $handle = fopen ("error_login.txt", "w");
        fwrite ($handle, $e->getMessage());
        fclose ($handle);
    }

    include 'footimport.php';
    ?>
    </body>
</html>