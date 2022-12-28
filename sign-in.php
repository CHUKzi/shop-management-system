<?php 
require_once('inc/connection.php');
$PN =  "sign-in";

if (isset($_GET['Registered'])) {
    if ($_GET['Registered']=="no") {
    $warnings[] = "Please Login And Continue";
  }
}

if (isset($_SESSION['user_id'])) {
  header( 'Location: '. $BaseUrl.'user.php?Login-User_login_successfully!!' );
}

if (isset($_POST['login'])) {

  $warnings = array();
  $email             =  $_POST['email'];
  $hashed_password   =  sha1($_POST['password']);

  $query = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$hashed_password}' AND is_deleted iS NULL LIMIT 1";
  $result_set = mysqli_query($connection, $query);

  if ($result_set) {
    if (mysqli_num_rows($result_set) == 1) {
      $user = mysqli_fetch_assoc($result_set);
      $_SESSION['user_id'] = $user['id'];
      $query = "UPDATE users SET last_login = NOW() ";
      $query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";
      $result_set = mysqli_query($connection, $query);
      header('Location:'. $BaseUrl .'user.php');
    } else {
      $warnings[] = 'Invalid Username / Password';
    }
  } else {
    $errors[] = 'Login failed';
  }
  
}

if (isset($_POST['register'])) {

  require_once('inc/Functions/EmailFunction.php');

  $warnings   = array();

  if (!is_email($_POST['email'])) {
    $warnings[] = 'Email address is invalid.';
  }

  $query = "SELECT * FROM users WHERE email = '{$_POST['email']}' LIMIT 1";
  $result_set = mysqli_query($connection, $query);
  if ($result_set) {
    if (mysqli_num_rows($result_set) == 1) {
      $warnings[] = 'You are already Registered';
    }
  }

  if ($_POST['password']==$_POST['repassword']) {
    $password = sha1($_POST['password']);
  } else {
    $warnings[] = "password and confirm password must be match";
  }

  if (empty($warnings)) {

    $query  = "INSERT INTO users (";
    $query .= "first_name, last_name, email, password, contact_number, province, district, address, acountType";
    $query .= ") VALUES (";
    $query .= "'{$_POST['first_name']}', '{$_POST['last_name']}', '{$_POST['email']}', '{$password}', '{$_POST['contact_number']}', '{$_POST['province']}', '{$_POST['district']}', '{$_POST['address']}', 'user' ";
    $query .= ")";

    $result = mysqli_query($connection, $query);
    if ($result) {
      $suces = 'You Are Registered!!';
    } else {
      $errors = 'Registered failed';
    }

  }

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

<?php include('inc/interface/Header.php');?>

<main role="main">

  <div class="container marketing">
      <br>
      <?php include('inc/interface/custom/AlertsFunction.php'); ?>
        <div class="row">

              <div class="col">
 </p><h3 style="text-align: center;">User Login</h3><p>
                  <div class="card">
                      <div class="card-body">

                            <form method="post">
                              <div class="form-group">
                                  <label for="email">Email address</label>
                                  <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                              </div>
                              <div class="form-group">
                                  <label for="password">password</label>
                                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                              </div>
                              <div class="mx-auto">
                                <label>
                                  <input type="checkbox" value="remember-me"> Remember me
                                </label>
                              </div>
                              <button class="btn btn-lg btn-warning text-white btn-block" type="submit" name="login">Sign in</button>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-sm-6">
 </p><h3 style="text-align: center;">User Register</h3><p>
                  <div class="card">
                    <div class="card-body">

                        <form method="post">
                            
                            <div class="row mb-4">
                              <div class="col">
                                <div class="form-outline">
                                  <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" value="" required>
                                </div>
                              </div>

                              <div class="col">
                                <div class="form-outline">
                                  <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" value="" required>
                                </div>
                              </div>
                            </div>

                            <input type="email" id="email" name="email" class="form-control" placeholder="Email address" value="" required="">
                            <br>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
                            <br>
                            <input type="password" id="repassword" name="repassword" class="form-control" placeholder="Re-Enter Password" required="">
                            <br>

                            <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Contact Number" required>
                            <br>


                            <div class="row mb-4">
                              <div class="col">
                                <div class="form-outline">
                                  <select class="form-control" name="province" required>

                                     <option value="Southern">Selecte Province</option> 
                                    <option value="Southern">Southern</option>
                                    <option value="Western">Western</option>
                                    <option value="Central">Central</option>
                                    <option value="Eastern">Eastern</option>
                                    <option value="North Central">North Central</option>
                                    <option value="Northern">Northern</option>
                                    <option value="North Western">North Western</option>
                                    <option value="Sabaragamuwa">Sabaragamuwa</option>
                                    <option value="Uva">Uva</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col">
                                <div class="form-outline">
                                  <select class="form-control" name="district">

                                     <option value="Galle">Selecte District</option> 
                                    <option value="Kandy">Kandy</option>
                                    <option value="Matale">Matale</option>
                                    <option value="Nuwara Eliya">Nuwara Eliya</option>
                                    <option value="Ampara">Ampara</option>
                                    <option value="Batticaloa">Batticaloa</option>
                                    <option value="Trincomalee">Trincomalee</option>
                                    <option value="Anuradhapura">Anuradhapura</option>
                                    <option value="Polonnaruwa">Polonnaruwa</option>
                                    <option value="Jaffna">Jaffna</option>
                                    <option value="Kilinochchi">Kilinochchi</option>
                                    <option value="Mannar">Mannar</option>
                                    <option value="Mullaitivu">Mullaitivu</option>
                                    <option value="Vavuniya">Vavuniya</option>
                                    <option value="Kurunegala">Kurunegala</option>
                                    <option value="Puttalam">Puttalam</option>
                                    <option value="Kegalle">Kegalle</option>
                                    <option value="Ratnapura">Ratnapura</option>
                                    <option value="Galle">Galle</option>
                                    <option value="Hambantota">Hambantota</option>
                                    <option value="Matara">Matara</option>
                                    <option value="Badulla">Badulla</option>
                                    <option value="Monaragala">Monaragala</option>
                                    <option value="Colombo">Colombo</option>
                                    <option value="Gampaha">Gampaha</option>
                                    <option value="Kalutara">Kalutara</option>
                                  </select>

                                </div>
                              </div>
                            </div>

                            <input type="text" id="address" name="address" class="form-control" placeholder="Address" required>
                            <br>

                            <div class="mx-auto">
                              <label>
                                <input type="checkbox" value="remember-me" required> i agree <b>terms and conditions</b>
                              </label>
                            </div>

                            <button class="btn btn-lg btn-warning text-white btn-block" type="submit" name="register">Sign Up</button>
                          </form>

                      </div>
                  </div>
              </div>
          </div>

  <hr class="featurette-divider">

</div>

  <?php include('inc/interface/Footer.php'); ?>
</main>
<script src="<?php echo $BaseUrl;?>js/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>

<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>
<?php mysqli_close($connection); ?>