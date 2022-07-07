<?php

    // Initialisierung der Session.
  // Wenn Sie session_name("irgendwas") verwenden, vergessen Sie es
  // jetzt nicht!
  session_start();
  if($_SESSION['login']!=111)
{
  //Sofort Logout!
  header("Location: login.php");
}
//   $sEmail=$_SESSION["email"];
//   try
//       {
//           //DB
//           include 'dbsettings.php';
//           //verbindung zur datenbank
//           $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
//           //set the PDo error mode to exception
//           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
//           //SQL
//           $sqlUpdateLoggedIn="UPDATE ws_login SET loggedin ='0' WHERE ws_login.email =?";
//           $stmt2=$conn->prepare($sqlUpdateLoggedIn);
//           $stmt2->execute([$sEmail]);


//           $conn = null;
//       }
//           catch(PDOException $e) 
//           {
//               $handle = fopen ("error_login.txt", "w");
//               fwrite ($handle, $e->getMessage());
//               fclose ($handle);
//           }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="3; url= portalview.php" />
    <title>Logout</title>

    <?php
    include 'headimport.php';
    ?>

  </head>
  
  <body>
    <br><br>
    <div class="container-fluid">
      <div class="row text-center">
         <h1>Thanks for your order!</h1>
         <h5>Check your e-mail for the details!</h5>
         <br>
         <div style="width:40% height:40%">
            <a href="portalview.php">
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