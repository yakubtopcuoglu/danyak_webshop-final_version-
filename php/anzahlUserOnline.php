<?php
try
{
    //DB
    include 'dbsettings.php';
    //verbindung zur datenbank
    $conn = new PDO("mysql:host=localhost;dbname=".$dbDatabasename,$dbLoginUsername,$dbPassword);
    //set the PDo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //SQL
    $result=$conn->prepare("SELECT COUNT(loggedin) as anzahlUserOnline FROM ws_login WHERE loggedin =1");
    $result->execute();
    $ergebnis = $result->fetchAll();
    
    
    foreach($ergebnis as $zeile)
    {
        $onlineUser=$zeile["anzahlUserOnline"];
    }
    echo(int)$onlineUser . " user online";
    $conn = null;
}
catch(PDOException $e)
{
    $handle = fopen ("error_login.txt", "w");
    fwrite ($handle, $e->getMessage());
    fclose ($handle);
}











?>