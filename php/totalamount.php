<?php
session_start();
if(isset($_SESSION["activediscountpercent"])){
    $gesamtsumme = $_SESSION["totalwithdiscount"];
    if($_GET["auswahl"]=="6"){        // DPD Auswahl mit value = 6
        
        echo round($gesamtsumme+6,2);
        $_SESSION["pricewithamount"] = round($gesamtsumme+6,2);
        $_SESSION["shippingcost"] = 6;
    
    }else if($_GET["auswahl"]=="15"){ // DHL Auswahl mit value = 15
        
        echo round($gesamtsumme+15,2);
        $_SESSION["pricewithamount"] = round($gesamtsumme+15,2);
        $_SESSION["shippingcost"] = 15;
    }
    else if($_GET["auswahl"]=="33"){  // DHL Express Auswahl mit value = 33
        echo round($gesamtsumme+33,2);
        $_SESSION["pricewithamount"] = round($gesamtsumme+33,2);
        $_SESSION["shippingcost"] = 33;
    }


}
else{
    $gesamtsumme = $_SESSION["totalprice"];
    if($_GET["auswahl"]=="6"){        // DPD Auswahl mit value = 6
        
        echo round($gesamtsumme+6,2);
        $_SESSION["pricewithamount"] = round($gesamtsumme+6,2);
        $_SESSION["shippingcost"] = 6;
    
    }else if($_GET["auswahl"]=="15"){ // DHL Auswahl mit value = 15
        
        echo round($gesamtsumme+15,2);
        $_SESSION["pricewithamount"] = round($gesamtsumme+15,2);
        $_SESSION["shippingcost"] = 15;
    }
    else if($_GET["auswahl"]=="33"){  // DHL Express Auswahl mit value = 33
        echo round($gesamtsumme+33,2);
        $_SESSION["pricewithamount"] = round($gesamtsumme+33,2);
        $_SESSION["shippingcost"] = 33;
    }
}


//round($gesamtsumme,2);

?>