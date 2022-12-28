<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="<?php echo $BaseUrl;?>"><img src="images/navibar.png" width="40">Aswanna <?php if (isset($_SESSION['user_id'])) { if ($login_u['acountType']=="admin") { echo  '<span class="">Admin</span>'; } }  ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">

         <span class="navbar-toggler-icon"></span>

        </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link <?php if ($PN =="Home"){echo 'text-warning';}?>" style=" color: white;" href="<?php echo $BaseUrl;?>"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php if ($PN =="Categories"){echo 'text-warning';}?>" style=" color: white;" href="<?php echo $BaseUrl;?>categories.php"><i class="fa fa-list-alt"></i> Categories</a>
                </li>

               <li class="nav-item">
                  <a class="nav-link <?php if ($PN =="About-Us"){echo 'text-warning';}?>" style=" color: white;" href="<?php echo $BaseUrl;?>about.php"><i class="fa fa-info-circle"></i> About Us</a>
                </li>

               <li class="nav-item">
                  <a class="nav-link <?php if ($PN =="Terms&use"){echo 'text-warning';}?>" style=" color: white;" href="<?php echo $BaseUrl;?>Terms&use.php"><i class="fa fa-circle-o"></i> Terms & use</a>
                </li>

               <li class="nav-item">
                  <a class="nav-link <?php if ($PN =="privacy-policy"){echo 'text-warning';}?>" style=" color: white;" href="<?php echo $BaseUrl;?>privacy-policy.php"><i class="fa fa-circle-o"></i> Privacy Policy</a>
                </li>

               <li class="nav-item">
                  <a class="nav-link <?php if ($PN =="payment-methods"){echo 'text-warning';}?>" style=" color: white;" href="<?php echo $BaseUrl;?>payment.php"><i class="fa fa-paypal"></i> Payment Methods</a>
                </li>

               <li class="nav-item">
                  <a class="nav-link <?php if ($PN =="contact-us"){echo 'text-warning';}?>" style=" color: white;" href="<?php echo $BaseUrl;?>contact.php"><i class="fa fa-phone"></i> Contact Us</a>
                </li>
            </ul>
        </div>

        <div style="margin-left: 5px;">

            <?php if (isset($_SESSION['user_id'])) {

            $query = "SELECT favorite.*,products.* FROM favorite INNER JOIN products ON favorite.ProductID = products.product_id WHERE favorite.fav_by ='{$_SESSION['user_id']}' ORDER BY favorite.time DESC";
            $UserfavInfo = mysqli_query($connection, $query);
            $row_results_fav=mysqli_num_rows ($UserfavInfo); ?>
            
            
            <a href="<?php echo $BaseUrl;?>items.php?category=all&info=favorite"><button type="button" class="btn btn-light" style="border-radius: 25px;"><i class="fa fa-heart" aria-hidden="true"></i>&nbsp;<span><?php echo $row_results_fav ?></span></button></a>

             <?php }  ?>    

            <?php if (isset($_SESSION['user_id'])) {
                
            $query = "SELECT cart.*,products.* FROM cart INNER JOIN products ON cart.ProductID = products.product_id WHERE cart.cart_by ='{$_SESSION['user_id']}' AND cart.PayORDelivery IS NULL ORDER BY cart.time DESC";
            $addCart = mysqli_query($connection, $query);
            $row_results=mysqli_num_rows ($addCart); } else {
                $row_results = "0";
            }
            ?>

            <a href="<?php echo $BaseUrl;?>user.php?page=cart"><button type="button" class="btn btn-light" style="border-radius: 25px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;<span><?php echo $row_results; ?></span></button></a>

            <?php if (isset($_SESSION['user_id'])) {?>
            <a href="<?php echo $BaseUrl;?>user.php"><button class="btn btn-warning my-2 my-sm-0"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $login_u['first_name'];?> </button></a>

            <?php } else { ?>
            <a href="<?php echo $BaseUrl;?>sign-in.php"><button class="btn btn-warning my-2 my-sm-0"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</button></a>
            <?php } ?>


  
        </div>
    </nav>
</header>