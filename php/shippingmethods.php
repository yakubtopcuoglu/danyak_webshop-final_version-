<?php
session_start();

if($_GET["auswahl"]=="6")
{
    echo"6€";
    $_SESSION["versandart"]="DPD";

}else if($_GET["auswahl"]=="15")
{
    //$gesamtsumme = (double)$_SESSION["gesamtsumme"];
    echo "15€";
    $_SESSION["versandart"]="DHL";
}

else if ($_GET["auswahl"]=="33"){
    echo"33€";
    $_SESSION["versandart"]="DHLExpress";
}

$_SESSION["versandartAuswahl"]=$_GET["auswahl"];

?>