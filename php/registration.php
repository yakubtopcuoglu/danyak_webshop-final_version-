<?php

//PHP Session starten!
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

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
        // session_start();

        // if(isset($_SESSION["loggedin"])){
        //     if($_SESSION["loggedin"]=1){
        //         echo "<a href=logout.php><i class=fas fa-sign-out-alt></i> Logout</a>  ";
        //     }else{
        //         echo "<a href=login.php><i class=fas fa-sign-out-alt></i> Login</a>  ";
        //     }

        // }else{
        //     echo "<a href=login.php><i class=fas fa-sign-out-alt></i> Login</a>  ";
        // }
    ?>

    <!--Registrierung Form-->

    <form method="POST" action="executeRegistration.php" id="regForm" class="form-horizontal" role="form">
    <div class="container ">

        <div class="row">
            <h1>Create account</h1>
            Name
            <div style="margin-bottom: 25px" class="input-group"> 
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="regFirstname" type="text" name="firstname" value="" placeholder="" required>                                        
            </div>

            Surname 
            <div style="margin-bottom: 25px" class="input-group"> 
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="regSurname" type="text" name="surname" value="" placeholder="" required>                                        
            </div>

            E-Mail
            <div style="margin-bottom: 25px" class="input-group"> 
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="regEmail" type="mail" name="email" placeholder="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" minlength="5" required>   
            </div>

            <div id="checkEmail">
                <p id="checkEmail"></p>
            </div>

            <br>
            Street
            <div style="margin-bottom: 25px" class="input-group"> 
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="regStreet" type="text" name="str" value="" placeholder="" required>
            </div>

            City
            <div style="margin-bottom: 25px" class="input-group"> 
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="regCity" type="text" name="city" value="" placeholder="" required>
            </div>

            Zip code
            <div style="margin-bottom: 25px" class="input-group"> 
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="regZip" type="text" name="zip" value="" placeholder="" required>
            </div>

            You will receive the password by email!

            <p></p>

            <div class="col-sm-12 controls">
                <button type="submit" class="btn btn-dark" id="regBtn">Create account</button>
            </div>                  
        </div>      
    </div>
    </form>
    
    <script>
        $(document).ready(function() {
            $("#checkEmail").load("checkEmail.php");
                var refreshId = setInterval(function() {
                    $("#checkEmail").load("checkEmail.php");
            }, 10000);
        });
    </script>

    <?php
      include 'footimport.php';
    ?>
</body>
</html>