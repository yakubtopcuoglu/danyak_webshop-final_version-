<?php

if($_SESSION["login"] != 111)
{
  //Sofort Logout!
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>

    <?php
    include 'headimport.php';
    ?>
</head>
<body>
    

    <?php
    include 'navimport.php';
    ?>

    <!--Neues PW Form-->
    <form method="POST" action="executeNewPW.php" id="newPwForm" role="form">
        <div class="container">
            <div class="row"></div>
            
            <p></p>

            <div class="row">
                
                <h3>Set your own password please:</h3>
                <p></p>
                New password: 
                <div style="margin-bottom: 25px" class="input-group" > 
                    <span class="input-group-addon" ><i class="glyphicon glyphicon-user" ></i></span>
                    <input id="tfNewPw" type="password" name="tfNewPw" value="" placeholder="" minlength="9" pattern="(?=^.{9,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>       
                </div>

                New password again: 
                <div style="margin-bottom: 25px" class="input-group"> 
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="tfNewPwRepeat" type="password" name="tfNewPwRepeat" value="" placeholder="" minlength="9" pattern="(?=^.{9,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required> 
                </div>

                <p></p>

                <div class="col-sm-12 controls">
                    <button type="submit" class="btn btn-success" id="newPwBtn">Change password</button>
                </div>
            </div>
        </div>
    </form>

    <?php
    include 'footimport.php';
    ?>
</body>
</html>