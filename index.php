<?php 
require_once('inc/connection.php');
$PN =  "Home";

if (isset($_POST['SearchBTN'])) {

    header( 'Location: '. $BaseUrl.'items.php?category=all&search='.$_POST['search']);
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

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">

        <img src="images/slide/slide1.jpg" class="bd-placeholder-img">

        <div class="container">
          <div class="carousel-caption text-center">
            <h1 class="text-info" style="font-size: 85px;">Welcome to </br> Agricultural Store</h1>
            <p><a class="btn btn-lg btn-warning text-white" href="#" role="button"><i class="fa fa-shopping-cart" aria-hidden="true"></i> View Agricultural Store</a> </p>
            <br><br>
            <?php include('inc/interface/custom/Search.php'); ?>
            <br><br>
          </div>
        </div>
      </div>


    </div>

  </div>


<div class="container marketing">


<?php include('inc/interface/custom/categorizeICons.php'); ?>

<hr class="featurette-divider">

      <div class="jumbotron">
        <img src="<?php echo $BaseUrl;?>images/navibar.png">
        <h1>Aswanna</h1>
        <p class="lead"><!-- About Aswanna --></p>
        <a class="btn btn-lg btn-warning text-white" href="<?php echo $BaseUrl;?>" role="button">About Us &raquo;</a>
      </div>
 </div>



 <hr class="featurette-divider">

<?php include('inc/interface/Footer.php'); ?>
</main>

<script src="<?php echo $BaseUrl;?>js/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>

<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>
<?php mysqli_close($connection); ?>
