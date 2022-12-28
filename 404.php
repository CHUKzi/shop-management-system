<?php 
require_once('inc/connection.php');
$PN =  "404";
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

<h1 style="font-size:175px; text-align: center;">404</br><i class="fa fa-frown-o" aria-hidden="true"></i></h1>
<p style="text-align:center;">Page Not Found <a href="<?php echo $BaseUrl;?>">Click Here</a> For Home Page</p>

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
