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

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal</title>

    <?php
    include 'headimport.php';
    ?>
    
  </head>
  <body>
    <div class="container">
        <?php
        include 'navimport.php';
        ?>

        <br>
            <div class="row">
                <h1>Welcome to Danyak Shop!</h1>
                <!-- <p>Good to see you <b><?php echo $_SESSION['firstname']." ".$_SESSION['surname'] ?></b></p> -->
                
                <?php
                   
                if(isset($_SESSION["loggedin"]))
                {
                  if($_SESSION["loggedin"]=1)
                  {
                    $sEmail=$_SESSION["email"];

                    try
                    {   
                      //DB
                      include 'dbsettings.php';
                      //verbindung zur datenbank
                      $conn = new PDO("mysql:host=localhost;dbname=".$dbDatabasename,$dbLoginUsername,$dbPassword);
                      //set the PDo error mode to exception
                      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      
                      $sqlLastLogin = ("SELECT logindate  FROM user_data WHERE email='$sEmail' ORDER BY logindate DESC");

                      $abfrage = $conn->prepare($sqlLastLogin);
                      $abfrage->execute();
                      $ergebnis = $abfrage->fetchAll();
                      if(sizeof($ergebnis)== 1)
                      {
                        $datumUnformatiert=date("d.m.Y");
                        
                      }
                      else
                      {
                        $datumUnformatiert = substr(implode($ergebnis[1]),0,-28);
                      }
                      
                      $dateumFormatiert= date('D,d.m.Y ' ,strtotime($datumUnformatiert));
                      echo"<p>Hello "."<b>".$_SESSION["firstname"]." ".$_SESSION["surname"]."</b>".". You were last online on "."<b>".$dateumFormatiert."</b>".".<p>";
                    }
                    catch(PDOException $e)
                    {
                      $handle = fopen ("error_login.txt", "w");
                      fwrite ($handle, $e->getMessage());
                      fclose ($handle);
                    }
                  }
                  else
                  {
                    //Da nicht eingelogt ist wird auf login weitergeleitet
                    header("Location: login.php");
                  }
                }
                else
                {
                  //Da nicht eingelogt ist wird auf artikelübersicht weitergeleitet
                  header("Location: login.php");
                }   
                ?>
                
                
            </div>

        <p id="online">Test</p>
        
        <?php
        include 'carouselimport.php';
        ?>
    </div>

    <br>
    
    <!-- JS Anzahl User Online Link-->
    <script src="../node_modules/jquery/jquery.js"></script>

    <script>
    $(document).ready(function() 
    {
      $("#online").load("anzahlUserOnline.php");
            var refreshId = setInterval(function() 
            {
                $("#online").load("anzahlUserOnline.php");
            }, 2000);
    });
    </script>

    <?php
      include 'footimport.php';
    ?>

  </body>

</html>