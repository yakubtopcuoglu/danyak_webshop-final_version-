
<div class="container">
        <br>
            <div class="page-header" style="background-color:rgba(28,28,26,255)">
                <div class="row">
                    <div class="col col-sm-4">
                      <a href="overview.php">
                      <img src="../images/logo_danyak_vektor-1.png" 
                    class="img-responsive" 
                    width="100px">
                      </a>
                    </div>
                    <div class="col col-sm-4" style="color:white;text-align:center">
                      <h1>Danyak Shop</h1><h4>play games have fun!</h4>
                    </div>
                    <div class="col col-sm-4"></div>  
                </div>
            </div>

<!-- Static navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="product.php">Danyak Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <?php
        if(isset($_SESSION["loggedin"])){
            if($_SESSION["loggedin"]=1){
                echo "<a class=nav-link href=portalview.php><i class=fas fa-sign-out-alt></i> Home</a>  ";
            }else{
                echo "<a class=nav-link href=overview.php><i class=fas fa-sign-out-alt></i> Home</a>  ";
            }

        }else{
            echo "<a class=nav-link href=overview.php><i class=fas fa-sign-out-alt></i> Home</a>  ";
        }
        ?>

        <li class="nav-item">
          <a class="nav-link" href="product.php">Products</a>
        </li>

        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Products
          </a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="product.php">All Products</a></li>
            <li><a class="dropdown-item" href="product.php?parameter=sport">Sport</a></li>
            <li><a class="dropdown-item" href="product.php?parameter=action">Action</a></li>
            <li><a class="dropdown-item" href="product.php?parameter=strategy">Strategy</a></li>
            <li><a class="dropdown-item" href="product.php?parameter=rpg">RPG</a></li>
          </ul>
        </li> -->

        <li class="nav-item">
          <a href="shoppingcart.php">
            <button type="button" class="btn btn-dark">
              Shopping cart <span class="badge badge-primary" style="background-color:white;color:black;font-size:14px">
              
            <!-- Dynamische Warenkorbanzeige in Nav Bar -->
            <?php
              try
                {  
                  //DB
                  include 'dbsettings.php';

                  $conn = mysqli_connect($servername,$dbLoginUsername,$dbPassword,$dbDatabasename);
                  

                
                $total;
                if(isset($_SESSION["loggedin"]))
                {
                  if($_SESSION["loggedin"]=1)
                  {
                    
                  //Warenkorbergebnis noch anpassen sodass nur der Warenkorb vom eingeloggten Benutzer angezeigt wird.
                  $sql = "SELECT SUM(amount) AS sumamount FROM shoppingcart WHERE email = '$_SESSION[email]'";
                  $result = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($result);
                  $total = $row["sumamount"];
                  if($total < 1){
                    $total=0;
                  }
                  printf($total);
                  }
                }
                else{
                  $total=0;
                  printf($total);
                }
                

                  $conn = null;
            }
                catch(PDOException $e)
                {
                    $handle = fopen ("error_login.txt", "w");
                    fwrite ($handle, $e->getMessage());
                    fclose ($handle);
                }
                  ?>
</span>
            </button>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="myOrders.php">My orders</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="registration.php">Registration</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login/Logout
          </a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="login.php">Login</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <form method="POST" action="searchProduct.php" class="form-inline" >
            <div class="form-group">
              <div class="input-group">
                <input class="form-control mr-sm-2 me-2" type="search" placeholder="Search for a product" id="searchProduct" name="searchProduct" aria-label="Search">
                <span class="input-group-btn">
                  <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </span>
              </div>
            </div>
          </form>
        </li>

      </ul>
    </div>
  </div>
</nav>
