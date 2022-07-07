<?php

session_start();

    if($_SESSION['loggedin']!=1)
  {
    //Sofort Logout!
    header("Refresh:3; url: login.php");
  }

$sDiscountcode="";

if(isset($_POST['discount_code']))
{
    $sDiscountcode=$_POST['discount_code'];
}

    try
    {
        //DB
        include 'dbsettings.php';

        //verbindung zur datenbank
        $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);

        //set the PDo error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        

        $sqlFindDiscount = "SELECT discountcode from discount WHERE discountcode='$sDiscountcode'";
        $query = $conn->prepare($sqlFindDiscount);
        $query->execute();

        if($sqlFindDiscount == true)
        {
            //SQL
            $sqlUseDiscount ="UPDATE discount SET codeused='1' WHERE discountcode=?";
            $stmt=$conn->prepare($sqlUseDiscount);
            $stmt->execute([$sDiscountcode]);


            $sqlDiscountPercent =  "SELECT * from discount WHERE discountcode='$sDiscountcode'";
            
            foreach ($conn->query($sqlDiscountPercent) as $row)
            {   $sDiscountChecker=true;
                $_SESSION["activediscountpercent"] = $row["percent"];
                $_SESSION["activediscountcode"] = $row["discountcode"];
                
            }

        header ("Location: order.php");
        }

        else
        {
        echo 'The discount code is false';
        header ("Location: order.php");
        }
        
        $conn = null;
    }

    catch(PDOException $e)
    {
        $handle = fopen ("error_discount.txt", "w");
        fwrite ($handle, $e->getMessage());
        fclose ($handle);
    }
    echo "test";
    //header("Location: login.php");




?>