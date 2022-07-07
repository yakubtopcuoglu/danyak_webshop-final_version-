<?php
session_start();
if(isset($_SESSION["login"]))
{

  if($_SESSION["login"] == 111)
  {
    //weiterleitung 
    header("Location: portalview.php");
  }
  else{

  }
}
  else{

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

  <?php
  include 'navimport.php';
  ?>

   <div class="container">  

      <!-- <div class="row justify-content-center">
        <div class="col-4 text-center">
          <h1>Login</h1>
          <br>
          <p>Please click on logo to go back to the main page!</p>
          <a href="../index.html">
            <img src="../images/logo_danyak_vektor-1.png" class="img-fluid" style="with:80%;height:80%"> 
          </a> 
        </div>
      </div> -->
        
      <div class="row justify-content-center">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
          <div class="panel panel-info" >
            <div class="panel-heading">
              <div class="panel-title">
                <h1>Login</h1>
              </div>
            </div>

<!-- JS Resolution -->
<script type="text/javascript">
   document.cookie = 'window_width='+screen.width+'; expires=Fri, 3 Aug 2901 20:47:11 UTC; path=/';
   document.cookie = 'window_height='+screen.height+'; expires=Fri, 3 Aug 2901 20:47:11 UTC; path=/';
</script>

<?php
//Resolution
// $_SESSION["sWidth"] = $_COOKIE['window_width'];
// $_SESSION["sHeight"]= $_COOKIE['window_height'];
//Resolution finish
?>

            <div style="padding-top:30px" class="panel-body" >
              <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12">
              </div>

              <!-- LOGIN FORM POST-->
            <form method="POST" action="testlogin.php" id="loginform"    class="form-horizontal" role="form">

                <!-- Method und action sind  wichtig fuer die Pruefung-->
                <div style="margin-bottom: 25px" class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                  </span>
                  <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" minlength="5"required>                                        
                </div>
                                          
                <div style="margin-bottom: 25px" class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-lock"></i>
                  </span>
                  <input id="login-password" type="password" class="form-control" name="password" placeholder="password" pattern="(?=^.{9,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"  minlength="9" required>
                </div>
                
                <!-- Login button -->
                <div style="margin-top:10px" class="form-group">
                  <div class="col-sm-12 controls">
                    <button type="submit" class="btn btn-dark">
                      Login
                    </button>
                  </div>
                </div>
            </form> 
          </div>

                <!-- Forgot your password? -->
                <form method="POST" action="forgotPW.php">
                  <div style="margin-top:10px" class="form-group">
                    <div class="col-sm-12 controls">
                      <button type="submit" class="btn btn-link">
                        Forgot your password?
                      </button>
                    </div>
                  </div>
                </form>
                
                <!-- Registration form -->
                <form method="POST" action="registration.php">
                  <div style="margin-top:10px" class="form-group">
                    <div class="col-sm-12 controls">
                      New customer?
                      <button type="submit" class="btn btn-link">
                        Register here
                      </button>
                    </div>
                  </div>
                </form>




                                
        </div>  
      </div>
    </div>

    
    <?php
    include 'footimport.php';
    ?>

  </body>

</html>