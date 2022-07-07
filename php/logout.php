<?php

    // Initialisierung der Session.
  // Wenn Sie session_name("irgendwas") verwenden, vergessen Sie es
  // jetzt nicht!
  session_start();
  if($_SESSION['loggedin']!=1)
{
  //Sofort Logout!
  header("Location: login.php");
}
  $sEmail=$_SESSION["email"];
  try
      {
          //DB
          include 'dbsettings.php';
          //verbindung zur datenbank
          $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
          //set the PDo error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
          //SQL
          $sqlUpdateLoggedIn="UPDATE ws_login SET loggedin ='0' WHERE ws_login.email =?";
          $stmt2=$conn->prepare($sqlUpdateLoggedIn);
          $stmt2->execute([$sEmail]);


          $conn = null;
      }
          catch(PDOException $e) 
          {
              $handle = fopen ("error_login.txt", "w");
              fwrite ($handle, $e->getMessage());
              fclose ($handle);
          }


  // Löschen aller Session-Variablen.
  $_SESSION = array();

  // Falls die Session gelöscht werden soll, löschen Sie auch das
  // Session-Cookie.
  // Achtung: Damit wird die Session gelöscht, nicht nur die Session-Daten!
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params["path"],
          $params["domain"], $params["secure"], $params["httponly"]
      );
  }

  // Zum Schluß, löschen der Session.
  session_destroy();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="3; url= overview.php" />
    <title>Logout</title>

    <?php
    include 'headimport.php';
    ?>

  </head>
  
  <body>
    <br><br>
    <div class="container-fluid">
      <div class="row text-center">
         <h1>Bis bald!</h1>
         <br>
         <div style="width:40% height:40%">
            <a href="../php/overview.php">
                <img src="../images/logo_danyak_vektor-1.png" class="img-fluid">
            </a>
         </div>
      </div>	  
    </div>


    <?php
      include 'footimport.php';
    ?>

  </body>
</html>