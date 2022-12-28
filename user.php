<?php 
require_once('inc/connection.php');
$PN =  "User";

if (!isset($_SESSION['user_id'])) {

  header( 'Location: '. $BaseUrl.'sign-in.php?Registered=no' );

}

if (isset($_POST['changePass'])) {
  $warnings   = array();

  $max_len_fields = array('newpassword' => 30, 'repassword' => 30);
  foreach ($max_len_fields as $field => $max_len) {
    if (strlen(trim($_POST[$field])) > $max_len) {
      $warnings[] = $field . ' must be less than ' . $max_len . ' characters';
    }
  }

  $cPassword = sha1($_POST['cpassword']);

  $query = "SELECT * FROM users WHERE password = '{$cPassword}' AND id = '{$_SESSION['user_id']}' LIMIT 1";
  $result_set = mysqli_query($connection, $query);

  if ($result_set) {
    if (mysqli_num_rows($result_set) == 1) {

      if ($_POST['newpassword']==$_POST['repassword']) {
        $newPassword = sha1($_POST['newpassword']);
      } else {
        $warnings[] = "New password and confirm password must be match";
      }
    } else {
      $warnings[] = "Current password is invalid";
    }

  }

  if (empty($warnings)) {
    $query = "UPDATE users SET password = '{$newPassword}' WHERE id='{$_SESSION['user_id']}'";
    $result = mysqli_query($connection, $query);
    if ($result) {
      //header( 'Location: '. $homeURL.'login.php?Registered=suces' );
      $suces = 'Your account is Change Successfully!';
    } else {
      $errors = 'Updated failed';
    }
  }
}

if (isset($_POST['editAccount'])){

 $warnings = array();

  if (empty($warnings)) {
    
    $query  = "UPDATE users SET first_name = '{$_POST['first_name']}', last_name = '{$_POST['last_name']}', email = '{$_POST['email']}', province = '{$_POST['province']}', district = '{$_POST['district']}', address = '{$_POST['h_address']}' WHERE id ='{$_SESSION['user_id']}'";

    $result = mysqli_query($connection, $query);

    if ($result) {
      //header( 'Location: '. $homeURL.'login.php?Registerd=suces' );
      $suces = 'Your account is update Successfully!!';
    $query = "SELECT * FROM users WHERE id='{$_SESSION['user_id']}'";
    $login = mysqli_query($connection, $query);
    $login_u = mysqli_fetch_assoc($login);

    } else {
      $errors = 'Update failed';
    }
  }

}


if (isset($_GET['removeProduct'])) {

  $query = "DELETE FROM cart WHERE id = '{$_GET['removeProduct']}' AND cart_by = '{$_SESSION['user_id']}'";
  $result = mysqli_query($connection, $query);

  if ($result) {
    $suces = 'Your Product is Removed From Cart Successfully';
  } else {
    $errors = 'Your Product is Removed From Cart failed';
  }
}

if (isset($_POST['pay'])) {
  $query = "UPDATE cart SET PayORDelivery = 'Card Payment' WHERE cart_by = '{$_SESSION['user_id']}'";
  $result = mysqli_query($connection, $query);

  if ($result) {

      $query  = "INSERT INTO orders (";
      $query .= "OrderBy, PayType";
      $query .= ") VALUES (";
      $query .= "'{$_SESSION['user_id']}', 'Card Payment'";
      $query .= ")";

      $result = mysqli_query($connection, $query);

    header( 'Location: '. $BaseUrl.'checkiing.php' );

  } else {
    $errors = 'Something is wrong. Please Check Back And Try Again';
  }
}


if (isset($_POST['delivery'])) {

  $query = "UPDATE cart SET PayORDelivery = 'Cash On Delivery' WHERE cart_by = '{$_SESSION['user_id']}'";
  $result = mysqli_query($connection, $query);

  if ($result) {

      $query  = "INSERT INTO orders (";
      $query .= "OrderBy, PayType";
      $query .= ") VALUES (";
      $query .= "'{$_SESSION['user_id']}', 'Cash On Delivery'";
      $query .= ")";

      $result = mysqli_query($connection, $query);

    header( 'Location: '. $BaseUrl.'checkiing.php' );
  } else {
    $errors = 'Something is wrong. Please Check Back And Try Again';
  }
}

if (isset($_GET['order'])) {
  $suces = "Your order will be received within 2-3 days</br>Thank you for being with us";
}
?>
<!doctype html>
<html lang="en" id="html">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Aswanna Store · <?php echo $PN;?></title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- carouselstyle -->
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">
    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- favicon-icon -->
    <link rel="icon" href="images/favicon.png" sizes="32x32" type="image/png">
    
  </head>

  <body>

<?php include('inc/interface/Header.php'); ?>

<main role="main">

  <div class="container marketing">
<br>
 
<!--  </p><h3 style="text-align: left;">Hellow</h3><p> -->
  <br>
<?php include('inc/interface/custom/AlertsFunction.php'); ?>
          <div class="row">
              <div class="col">
                  <div class="card">

                  <?php if($login_u['acountType']=='user') { if  (!(isset($_GET['page']))) { ?>

                  <div class="card-header bg-info text-white text-uppercase"><i class="fa fa-shopping-cart" aria-hidden="true"></i> My Order list</div>
                    <table class="table">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Order Date</th>
                          <th scope="col">Order Status</th>
                          <th scope="col">Payment Method</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php

                        $query = "SELECT * FROM orders WHERE OrderBy='{$_SESSION['user_id']}' ORDER BY time DESC";
                        $Orders = mysqli_query($connection, $query);
                        $num_Of_oders=mysqli_num_rows($Orders);
                        $cnt = 1;
                        if ($Orders) {
                        while ($myOrder = mysqli_fetch_assoc($Orders)) {?>

                        <tr>
                          <th scope="row"><?php echo $cnt;?></th>
                          <td><?php $d=strtotime($myOrder['time']); echo date("M d , D W", $d);?></td>
                          <td><span class="bg-primary text-white" style="border-radius: 25px; padding: 4px;">Shipped</span></td>
                          <td><?php echo $myOrder['PayType'];?></td>
                        </tr>
                      <?php $cnt++; }}  if (empty($num_Of_oders)) { echo "<td colspan='5'><center style='color: #FF0000;'>No More Orders Yet</center></td>"; } ?>
                      </tbody>
                    </table>
                    </div>

                  <?php } if (isset($_GET['page'])) { if ($_GET['page']=="cart") {  ?>

                  <div class="card-header bg-info text-white text-uppercase"><i class="fa fa-shopping-cart" aria-hidden="true"></i> My Cart</div>
                    <table class="table">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Product Image</th>
                          <th scope="col">Product Name</th>
                          <th scope="col">Product Price</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $cnt = 1;
                        $ProductsPrice = '0';
                        if ($addCart) {
                        while ($cartProduct = mysqli_fetch_assoc($addCart)) {?>
                        <tr>
                          <th scope="row"><?php echo $cnt; ?></th>
                          <td><img src="<?php echo $BaseUrl;?>images/products/<?php echo $cartProduct['product_image'];?>" width="75"></td>
                          <td><?php echo $cartProduct['product_name'];?></td>
                          <td>Rs.<?php $ProductsPrice=$ProductsPrice+$cartProduct['product_price'];  echo $cartProduct['product_price'];?></td>
                          <td><a href="<?php $BaseUrl;?>user.php?page=cart&removeProduct=<?php echo $cartProduct['id'];?>"><button type="button" class="btn btn-danger" style="border-radius: 25px;" onclick="return confirm('Are You Sure Sign Out?');"><i class="fa fa-times" aria-hidden="true"></i></button></a></td>
                        </tr>
                        <?php $cnt++; }} if (empty($row_results)) { echo "<td colspan='5'><center style='color: #FF0000;'>Cart is Empty Yet</center></td>"; } ?>
                      </tbody>
                    </table>
                    </div>

                  <?php } } } if ($login_u['acountType']=='admin') {?>


                  <div class="card-header bg-info text-white text-uppercase"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Messages</div>
                    <table class="table">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Users Name</th>
                          <th scope="col">Email Address</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php

                        $query = "SELECT * FROM contact_us ORDER BY time DESC";
                        $messages = mysqli_query($connection, $query);
                        $num_Of_messages=mysqli_num_rows($messages);
                        $cnt = 1;
                        if ($messages) {
                        while ($message = mysqli_fetch_assoc($messages)) {?>
                        <tr>
                          <th scope="row"><?php echo $cnt; ?></th>
                          <td><?php echo $message['name'];?></td>
                          <td><?php echo $message['email'];?></td>
                          <td><button type="button" class="btn btn-primary" style="border-radius: 25px;" data-toggle="modal" data-target="#MessageView-<?php echo $message['id'];?>"><i class="fa fa-eye" aria-hidden="true"></i></button></td>

                          <div class="modal fade" id="MessageView-<?php echo $message['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $message['name'];?>'s Contact Message</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">


                                <p>This Message Send From <?php echo $message['email'];?> (<?php echo $message['name'];?>)</p>

                                  <p class="h4">Message</p>
                                  <p><?php echo $message['message'];?></p>
                                </div>
                                <div class="modal-footer">
                                  <p>DATE & TIME <?php echo $message['time'];?></p>
                                </div>
                              </div>
                            </div>
                          </div>

                        <?php $cnt++; }} if (empty($num_Of_messages)) { echo "<td colspan='5'><center style='color: #FF0000;'>Not Yet</center></td>"; } ?>
                      </tbody>
                    </table>
                    </div>




                  <?php } ?>
                    
                  
              </div>
              <div class="col-12 col-sm-4">

                <?php if (!empty($row_results)) {  if (isset($_GET['page'])) { if ($_GET['page']=="cart") {   ?>

                  <div class="card bg-light mb-3">
                      <div class="card-header bg-info text-white text-uppercase"><i class="fa fa-calculator" aria-hidden="true"></i> Total</div>
                      <div class="card-body">
                        <table>

                          <tr>
                            <td>Total Products Price</td>
                            <td>:</td>
                            <td>Rs.<?php echo $ProductsPrice; ?></td>
                          </tr>

                          <tr>
                            <td>Delivery charges</td>
                            <td>:</td>
                            <td>Rs.<?php $dChage = '350'; echo $dChage; ?></td>
                          </tr>

                          <tr>
                            <td style="font-size:25px;">Total Bill</td>
                            <td style="font-size:25px;">:</td>
                            <td style="font-size:25px;">Rs.<?php echo $ProductsPrice+$dChage; ?></td>
                          </tr>
                        </table>

<div class="payment-method text-center">
<img src="<?php echo $BaseUrl;?>images/payment/payment-method1.jpg" alt="payment-method">
<img src="<?php echo $BaseUrl;?>images/payment/payment-method2.jpg" alt="payment-method">
<img src="<?php echo $BaseUrl;?>images/payment/payment-method3.jpg" alt="payment-method">
<img src="<?php echo $BaseUrl;?>images/payment/payment-method4.jpg" alt="payment-method">
</div>
                        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#cardPay"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Purchase Now</button>
<hr>
<p>Cash On Delivery within courier Your products in 2 OR 3 days</p>
<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#cashOnDilivery"><i class="fa fa-truck" aria-hidden="true"></i> Cash on Delivery</button>
                      </div>

                  </div>
                  <?php } } } ?>


                  <div class="card bg-light mb-3">
                      <div class="card-header bg-warning text-white text-uppercase"><i class="fa fa-home"></i> My Acount</div>
                      <div class="card-body">

                        <table>
                          <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td><?php echo $login_u['first_name']." ".$login_u['last_name']; ?></td>
                          </tr>

                          <tr>
                            <td>Email Addres</td>
                            <td>:</td>
                            <td><?php echo $login_u['email']; ?></td>
                          </tr>

                          <tr>
                            <td>From</td>
                            <td>:</td>
                            <td>Sri Lanka</td>
                          </tr>

                          <tr>
                            <td>Province</td>
                            <td>:</td>
                            <td><?php echo $login_u['province']; ?></td>
                          </tr>

                          <tr>
                            <td>District</td>
                            <td>:</td>
                            <td><?php echo $login_u['district']; ?></td>
                          </tr>

                          <tr>
                            <td>Home Address</td>
                            <td>:</td>
                            <td><?php echo $login_u['address']; ?></td>
                          </tr>

                          <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><?php echo $login_u['contact_number']; ?></td>
                          </tr>

                          <tr>
                            <td>Acount Type</td>
                            <td>:</td>
                            <td><?php echo strtoupper($login_u['acountType']); ?> Acount</td>
                          </tr>

                          <tr>
                            <td>last login</td>
                            <td>:</td>
                            <td><?php echo $login_u['last_login']; ?></td>
                          </tr>

                        </table>
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#EditAcoount"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Account</button>
                        <br>

                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#ChagePass"><i class="fa fa-key" aria-hidden="true"></i> Change Password</button>
                        <br>
                        <a href="logout.php" onclick="return confirm('Are You Sure Sign Out?');"><button type="button" class="btn btn-danger btn-block"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out</button></a>
                      </div>

                  </div>
              </div>
          </div>

<!-- Modal -->

<div class="modal fade" tabindex="-1" id="ChagePass" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $login_u['first_name'];?>'s Profile Password Change</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
  

<form method="post" enctype="multipart/form-data">


    <div class="form-group">
    <label for="c_password">Current Password</label>
    <input type="password" id="c_password" name="cpassword" class="form-control" placeholder="Current Password" required>
    </div>

    <div class="form-group">
    <label for="newpassword">New Password</label>
    <input type="password" id="newpassword" name="newpassword" class="form-control" placeholder="New Password" required>
    </div>

    <div class="form-group">
    <label for="ccpassword">Confrim Password</label>
    <input type="password" id="ccpassword" name="repassword" class="form-control" placeholder="Confrim Password" required>
    </div>


    <input class="" type="checkbox" name="showpassword" id="showpassword"> <label for="showpassword"> Show Password</label>



  <div class="bs-example">
    <div class="clearfix">
        <div class="pull-left"><button type="submit" class="btn btn-warning" name="changePass"><i class="fa fa-upload" aria-hidden="true"></i> Change Password</button></div>
      </div>
  </div>

</form>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" id="EditAcoount" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $login_u['first_name'];?>'s Profile </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
  

<form method="post" enctype="multipart/form-data">

<div class="row">
  <div class="col">
    <div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" value="<?php echo $login_u['first_name']; ?>" required>
    </div>
  </div>

  <div class="col">
    <div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo $login_u['last_name']; ?>" required>
  </div>
  </div>
</div>

<div class="row">
  <div class="col">
  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo $login_u['email']; ?>" required>
  </div>

</div>

<div class="col">
  <div class="form-group">
    <label for="province">Province</label>
    <input type="text" id="province" name="province" class="form-control" placeholder="Province" value="<?php echo $login_u['province']; ?>" required>
  </div>
  </div>
</div>

<div class="row">
<div class="col">
<div class="form-group">
  <label for="district">District</label>
  <input type="text" id="district" name="district" class="form-control" placeholder="District" value="<?php echo $login_u['district']; ?>" required>
</div>
</div>

<div class="col">
<div class="form-group">
  <label for="h_address">Home Address</label>
  <input type="text" id="h_address" name="h_address" class="form-control" placeholder="Home Address" value="<?php echo $login_u['address']; ?>" required>
</div>
</div>
</div>


<div class="form-group">
  <label for="m_number">Mobile Number</label>
  <input type="text" id="m_number" name="m_number" class="form-control" placeholder="Mobile Number" value="<?php echo $login_u['contact_number']; ?>" required>
</div>

<div class="form-group">
  <label for="m_number">Account Type</label>
    <select class="form-control" disabled>
      <option><?php echo strtoupper($login_u['acountType']); ?></option>
    </select>
</div>

  <div class="bs-example">
    <div class="clearfix">
        <div class="pull-left"><button type="submit" class="btn btn-warning" name="editAccount"><i class="fa fa-upload" aria-hidden="true"></i> Save Changes</button></div>
      </div>
  </div>

</form>

      </div>
    </div>
  </div>
</div>






<div class="modal fade" id="cardPay">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-credit-card"></i> Pay Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<div class="payment-method text-center">
<img src="<?php echo $BaseUrl;?>images/payment/payment-method1.jpg" alt="payment-method">
<img src="<?php echo $BaseUrl;?>images/payment/payment-method2.jpg" alt="payment-method">
<img src="<?php echo $BaseUrl;?>images/payment/payment-method3.jpg" alt="payment-method">
<img src="<?php echo $BaseUrl;?>images/payment/payment-method4.jpg" alt="payment-method">
</div>
<p style="text-align:center; font-size:30px;">Payment Amount : LKR.<?php echo $ProductsPrice+$dChage;?></p>


<form method="post">
  

<div class="card">
<div class="card-header">

<strong>Credit Card</strong>
<small>enter your card details</small>
</div>
<div class="card-body">
<div class="row">
<div class="col-sm-12">
<div class="form-group">
    

    
<label for="name">Name On Card</label>
<input class="form-control" id="name" type="text" placeholder="Enter your name" required>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="form-group">
<label for="ccnumber">Credit Card Number</label>


<div class="input-group">
<input class="form-control" type="text" placeholder="0000 0000 0000 0000" autocomplete="email" required>
<div class="input-group-append">
<span class="input-group-text">
<i class="fa fa-cc-visa" aria-hidden="true"></i>
</span>
</div>
</div> 
</div>
</div>
</div>

<div class="row">
<div class="form-group col-sm-4">
<label for="ccmonth">Month</label>
<select class="form-control" id="ccmonth" required>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option>12</option>
</select>
</div>
<div class="form-group col-sm-4">
<label for="ccyear">Year</label>
<select class="form-control" id="ccyear" required>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
<option>2026</option>
<option>2027</option>
<option>2028</option>
</select>
</div>
<div class="col-sm-4">
<div class="form-group">
<label for="cvv">CVV/CVC</label>
<input class="form-control" id="cvv" type="text" placeholder="123" required>
</div>
</div>
</div>
</div>

<div class="card-footer">
<button type="submit" name="pay" class="btn btn-primary btn-lg btn-block"><i class="fa fa-lock" aria-hidden="true"></i> Pay LKR.<?php echo $ProductsPrice+$dChage; ?></button>
</div>

</div>
</div>
</div>
</div>


</form>





      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cashOnDilivery">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-address-card" aria-hidden="true"></i> Cash ON Delivery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

<p style="text-align:center; font-size:30px;">Payment Amount : LKR.<?php echo $ProductsPrice+$dChage;?></p>


<form method="post">
  
<div class="card">
  <div class="card-header">
    <i class="fa fa-truck" aria-hidden="true"></i> Billing information
  </div>

  <table class="text-center">
  <tr>
  <td>Shipping Address</td>
  <td>:</td>
  <td><?php echo $login_u['address']." ".$login_u['district']." ".$login_u['province'];?> Sri Lanka</td>
  </tr>
  <td>Phone</td>
  <td>:</td>
  <td>+94 <?php echo $login_u['contact_number']; ?></td>
  </tr> 
  </table>

  <div class="card-footer">
<button type="submit" name="delivery" class="btn btn-primary btn-lg btn-block"><i class="fa fa-address-card" aria-hidden="true"></i> i have confirmed And Delivery</button>
  </div>
</div>

</form>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

  <hr class="featurette-divider">

</div>

  <?php include('inc/interface/Footer.php'); ?>
</main>

   <script>
        $(document).ready(function(){
            $('#showpassword').click(function(){
                if ( $('#showpassword').is(':checked') ) {
                    $('#password').attr('type','text');
                    $('#password2').attr('type','text');
                } else {
                    $('#password').attr('type','password');
                    $('#password2').attr('type','password');
                }
            });
        });
    </script>

<script src="<?php echo $BaseUrl;?>js/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>

<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>
<?php mysqli_close($connection); ?>
