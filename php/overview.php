
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
    <title>Overview</title>

    <?php
    include 'headimport.php'
    ?>
</head>
<body>
    
    <?php
    include 'navimport.php';
    ?>

    <br>
    
    <?php
    include 'carouselimport.php';
    ?>

    <br>

    <!-- <table class="table table-hover">
    <thead>
        <tr style="text-align:center">
            <th scope="col">Product-ID</th>
            <th scope="col">Product</th>
            <th scope="col">Description</th>
            <th scope="col">Price <i class="fas fa-euro-sign"></i> </th>
            <th scope="col">Shoppingcart <i class="fas fa-shopping-cart"></i></th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
    </table> -->

    <?php
    include 'footimport.php';
    ?>
    </body>
</html>