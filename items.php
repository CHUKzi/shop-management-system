<?php 
require_once('inc/connection.php');
$PN =  "Items";

if (isset($_POST['SearchBTN'])) {

    header( 'Location: '. $BaseUrl.'items.php?category=all&search='.$_POST['search']);
}

if (isset($_POST['UpdatePost'])){

 $warnings = array();


  $product_image    = '';
  $product_image    = $_FILES["product_image2"]["name"];

  if (!empty($product_image)) {
    $filename     = uniqid() . "-" . time();
    $extension    = strtolower(pathinfo( $_FILES["product_image2"]["name"], PATHINFO_EXTENSION ));
    $basename1     = $filename . "." . $extension;
    $source       = $_FILES["product_image2"]["tmp_name"];
    $destination  = "images/products/{$basename1}";
    $extensions_arr = array('jpeg' , 'jpg', 'png');
    if( in_array($extension,$extensions_arr) ){
      move_uploaded_file($source, $destination);
    } else {
        $warnings[] = 'File <b>EXTENSION</b> is not support, check file extension is <b>JPEG OR JPG</b>';
    } 
  } else {
    $basename1 = $_POST['p_img'];
  }

  if (empty($warnings)) {

    $infor = nl2br(strip_tags($_POST['infor']));

    $product_category = $_GET['category'];
    
    $query  = "UPDATE products SET product_name = '{$_POST['product_name']}', product_image = '{$basename1}', product_category = '{$_POST['p_catogry']}', product_price = '{$_POST['product_price']}', product_disc = '{$infor}' WHERE product_id ='{$_POST['p_id']}'";

    $result = mysqli_query($connection, $query);

    if ($result) {
      //header( 'Location: '. $homeURL.'login.php?Registerd=suces' );
      $suces = 'Product is update Successfully!!';

    } else {
      $errors = 'Post failed';
    }
  }



}

if (isset($_POST['uploadPost'])) {

  $warnings   = array();

  $product_image    = '';
  $product_image    = $_FILES["product_image"]["name"];

  if (!empty($product_image)) {
    $filename     = uniqid() . "-" . time();
    $extension    = strtolower(pathinfo( $_FILES["product_image"]["name"], PATHINFO_EXTENSION ));
    $basename1     = $filename . "." . $extension;
    $source       = $_FILES["product_image"]["tmp_name"];
    $destination  = "images/products/{$basename1}";
    $extensions_arr = array('jpeg' , 'jpg', 'png');
    if( in_array($extension,$extensions_arr) ){
      move_uploaded_file($source, $destination);
    } else {
        $warnings[] = 'File <b>EXTENSION</b> is not support, check file extension is <b>JPEG OR JPG</b>';
    } 
  } else {
    $warnings[] = 'Product Images is required';
  }

  if (empty($warnings)) {

    $infor = nl2br(strip_tags($_POST['infor']));

    $product_category = $_GET['category'];
    
    $query  = "INSERT INTO products (";
    $query .= "product_name, product_image, product_category, product_price, product_disc";
    $query .= ") VALUES (";
    $query .= "'{$_POST['product_name']}', '{$basename1}', '{$product_category}', '{$_POST['product_price']}', '{$infor}'";
    $query .= ")";

    $result = mysqli_query($connection, $query);

    if ($result) {
      //header( 'Location: '. $homeURL.'login.php?Registerd=suces' );
      $suces = 'Product Successfully!!';

    } else {
      $errors = 'Post failed';
    }
  }
}

if (isset($_GET['addCart'])) {

  if (isset($_SESSION['user_id'])) {

    $query = "SELECT * FROM cart WHERE cart_by = '{$_SESSION['user_id']}' AND ProductID = '{$_GET['addCart']}' AND PayORDelivery IS NULL LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    if ($result_set) {
      if (mysqli_num_rows($result_set) == 1) {
        $warnings[] = 'already Add This Product In Your cart';
      }
    }

    if (empty($warnings)) {
      $query  = "INSERT INTO cart (";
      $query .= "cart_by, ProductID";
      $query .= ") VALUES (";
      $query .= "'{$_SESSION['user_id']}', '{$_GET['addCart']}'";
      $query .= ")";

      $result = mysqli_query($connection, $query);

      if ($result) {

        $suces = 'Your Product Add To Cart Successfully!!';

      } else {
        $errors = 'failed';
      }
    }
  } else {

  $warnings[] = 'Please Login And Continue';

  }
}

if (isset($_GET['fav'])) {

  if (isset($_SESSION['user_id'])) { 

    $query = "SELECT * FROM favorite WHERE fav_by = '{$_SESSION['user_id']}' AND ProductID = '{$_GET['fav']}' LIMIT 1";
    $result_set = mysqli_query($connection, $query);
    if ($result_set) {
      if (mysqli_num_rows($result_set) == 1) {
        $warnings[] = 'already Add This Product In Your Favorite List';
      }
    }

    if (empty($warnings)) {
      $query  = "INSERT INTO favorite (";
      $query .= "fav_by, ProductID";
      $query .= ") VALUES (";
      $query .= "'{$_SESSION['user_id']}', '{$_GET['fav']}'";
      $query .= ")";

      $result = mysqli_query($connection, $query);

      if ($result) {

        $suces = 'Your Product Add To Favorite Successfully!!';

      } else {

        $errors = 'failed';

      }
    }
  } else {
    $warnings[] = 'Please Login And Continue';
  }
}

if (isset($_GET['favDelete'])) {


  $query = "DELETE FROM favorite WHERE id = '{$_GET['favDelete']}' AND fav_by = '{$_SESSION['user_id']}'";
  $result = mysqli_query($connection, $query);

  if ($result) {
    $suces = 'Product is Removed From Your Favorite List Successfully';
  } else {
    $errors = 'Removed failed';
  }

}

if (isset($_GET['DeleteProduct'])) {

    if ($login_u['acountType']=="admin") {

    $query = "DELETE FROM products WHERE product_id = '{$_GET['DeleteProduct']}'";
    $result = mysqli_query($connection, $query);

    if ($result) {
      $suces = 'Product is Delete Successfully';
    } else {
      $errors = 'Delete failed';
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
<?php include('inc/interface/custom/AlertsFunction.php'); ?>

<?php if (isset($_SESSION['user_id'])) { if ($login_u['acountType']=="admin") { ?>


<div class="text-center">
  <button class="btn btn-warning" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-upload" aria-hidden="true"></i> Upload A New Product</button> 
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i>Upload A New Product For </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
  

<form method="post" enctype="multipart/form-data">

  <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Product Name" required><br>

<img id="product_image" width="200"/>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp;Upload Image</span>
  </div>
  <div class="custom-file">
    <input type="file" class="custom-file-input" id="productImage" name="product_image" onchange="loadFile1(event)">
    <label class="custom-file-label" for="productImage">Choose Product Image (JPEG, JPG, PNG)</label>
  </div>
</div>

  <br>

   <div class="row mb-4">
     <div class="col">
       <div class="form-outline">

        <select class="form-control" name="houseType" required disabled>
          <option> Category "<?php echo $_GET['category'] ?>"</option> 
        </select>

      </div>
    </div>

    <div class="col">
      <div class="form-outline">
        <input type="Number" id="price" name="product_price" class="form-control" placeholder="Price (LKR)" name="price" required>
      </div>
    </div>
  </div>


  <div class="form-group">
    <label for="infor">Description (0 - 500 Characters)</label>
    <textarea class="form-control" id="infor" rows="3" name="infor" required></textarea>
  </div>

  <div class="bs-example">
    <div class="clearfix">
        <div class="pull-left"><button type="submit" class="btn btn-warning" name="uploadPost"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button></div>
      </div>
  </div>

</form>

      </div>
    </div>
  </div>
</div>

<?php } } ?>


<br><br>

<h1><?php echo strtoupper($_GET['category']);?></h1>

<?php include('inc/interface/custom/Search.php'); ?>

<br>

<?php include('inc/interface/Products.php'); ?>


  <hr class="featurette-divider">

</div>

  <?php include('inc/interface/Footer.php'); ?>
</main>

<script>
  var loadFile1 = function(event) {
  var image = document.getElementById('product_image');
  image.src = URL.createObjectURL(event.target.files[0]);

};

  var loadFile2 = function(event) {
  var image = document.getElementById('product_image2');
  image.src = URL.createObjectURL(event.target.files[0]);
};

</script>

<script src="<?php echo $BaseUrl;?>js/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>

<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>
<?php mysqli_close($connection); ?>
