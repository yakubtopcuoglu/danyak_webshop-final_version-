<?php
    
    $setminus=0;
    if(isset($_GET['mid']))
    {
        $setminus = $_GET['mid'];
    }

    if($setminus>0)
    {

        try
        {

        include 'dbsettings.php';

        //Verbindung zur Datenbank
        $conn = mysqli_connect($servername,$dbLoginUsername,$dbPassword,$dbDatabasename);

        $sql = "SELECT amount FROM shoppingcart WHERE productID = $setminus";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        $amount = $row[0];



        if($amount > 1){
            $conn->prepare("UPDATE shoppingcart SET amount = amount-1 WHERE productID=?")->execute([$setminus]);
        } else if($amount == 1){
            removeproduct();
        } else{
            //nicht möglich
        }



        // $conn->prepare("UPDATE shoppingcart SET amount = amount-1 WHERE productID=?")->execute([$setminus]);

        //Verbindung schließen
        $conn=null;
    } 
    catch(PDOException $e)
                {
                    $handle = fopen ("error_login.txt", "w");
                    fwrite ($handle, $e->getMessage());
                    fclose ($handle);
                }
    }

    header("Location: shoppingcart.php");


    function removeproduct(){
        $deletefromcart=0;
if(isset($_GET['mid']))
{
    $deletefromcart = $_GET['mid'];
}
if($deletefromcart>0)
{
    include 'dbsettings.php';

    //Verbindung zur Datenbank
    $conn = new PDO("mysql:host=localhost;dbname=".$dbDatabasename,$dbLoginUsername,$dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->prepare("DELETE FROM shoppingcart WHERE productID=?")->execute([$deletefromcart]);

    //Verbindung schließen
    $conn=null;
}
header("Location: shoppingcart.php");
}


?>