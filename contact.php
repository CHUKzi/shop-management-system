<?php 
require_once('inc/connection.php');
$PN =  "contact-us";

if (isset($_POST['SubmitContact'])) {

  $warnings   = array();

  $max_len_fields = array('name' => 30, 'email' =>40, 'message' => 500);
   foreach ($max_len_fields as $field => $max_len) {
    if (strlen(trim($_POST[$field])) > $max_len) {
      $warnings[] = $field . ' must be less than ' . $max_len . ' characters';
    }
  }

  require_once('inc/Functions/EmailFunction.php');

  if (!is_email($_POST['email'])) {
    $warnings[] = 'Email address is invalid.';
  }

  if (empty($warnings)) {

    $query  = "INSERT INTO contact_us (";
    $query .= "name, email, message";
    $query .= ") VALUES (";
    $query .= " '{$_POST['name']}', '{$_POST['email']}', '{$_POST['message']}' ";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      $suces = 'Your Contact Message is Send Successfully!!';

    } else {
      $errors = 'Message Send failed';
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

<?php include('inc/interface/Header.php'); ?>

<main role="main">

  <div class="container marketing">
<br>
 
 </p><h3 style="text-align: center;">Contact Us</h3><p>

<?php include('inc/interface/custom/AlertsFunction.php'); ?>
          <div class="row">
              <div class="col">
                  <div class="card">
                      <div class="card-body">
                                                  <form method="post">
                              <div class="form-group">
                                  <label for="name">Name</label>
                                  <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter name" required>
                              </div>
                              <div class="form-group">
                                  <label for="email">Email address</label>
                                  <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                              </div>
                              <div class="form-group">
                                  <label for="message">Message</label>
                                  <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                              </div>
                              <div class="mx-auto">
                              <button type="submit" name="SubmitContact" class="btn btn-warning text-white">Submit</button></div>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-sm-4">
                  <div class="card bg-light mb-3">
                      <div class="card-header bg-warning text-white text-uppercase"><i class="fa fa-home"></i> Address</div>
                      <div class="card-body">
                          <p>227/A1 Ambalangoda</p>
                          <p>Sri Lanka</p>
                          <p>Email : aswanna@gmail.com</p>
                          <p>Tel. 077123456789</p>
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
