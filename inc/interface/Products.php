<div class="row clearfix">

<?php 

if ($PN=="Items") {

    if ($_GET['category']=="all" OR $_GET['category']=="other") {//$_GET['category']=="all" OR $_GET['category']=="other"

        if (isset($_GET['info'])) { if ($_GET['info']=="favorite") {

        $query = "SELECT favorite.*,products.* FROM favorite INNER JOIN products ON favorite.ProductID = products.product_id WHERE favorite.fav_by ='{$_SESSION['user_id']}' ORDER BY favorite.time DESC";

        } }  else {

            if (isset($_GET['search'])) { //WHERE  (title LIKE '%{$_GET['search']}%' OR type LIKE '%{$_GET['search']}%')

            $query = "SELECT * FROM products WHERE (product_name LIKE '%{$_GET['search']}%' OR product_category LIKE '%{$_GET['search']}%') ORDER BY time DESC";

            } else {

                if ($_GET['category']=="all") {

                    $query = "SELECT * FROM products ORDER BY time DESC";
                }

                if ($_GET['category']=="other") {

                    //$query = "SELECT * FROM products ORDER BY time DESC";
                    $query = "SELECT * FROM products WHERE product_category='{$_GET['category']}' ORDER BY time DESC";
                }

                //$query = "SELECT * FROM products ORDER BY time DESC";
            }
            
        }

    } else {

        $query = "SELECT * FROM products WHERE product_category='{$_GET['category']}' ORDER BY time DESC";

    }
}

$Products = mysqli_query($connection, $query);
$row_results=mysqli_num_rows ($Products);
if ($Products) {
while ($Product = mysqli_fetch_assoc($Products)) {?>

<div class="col-lg-3 col-md-4 col-sm-12" style="margin-bottom:25px;">
<div class="card product_item">
<div class="body">
<a href="#!" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>" >
<div class="cp_img">
<img src="<?php echo $BaseUrl;?>images/products/<?php echo $Product['product_image'];?>" alt="Product" class="img-fluid">
<div class="hover">
                            
</div>
</div>
</a>
<div class="product_details text-center">
<h5><a href="#!" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>" ><?php echo $Product['product_name'];?></a></h5>
<ul class="product_price list-unstyled">
<li class="old_price" style="font-size:25px;">Rs.<?php echo $Product['product_price'];?></li>
<hr>

<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart</button>

<?php if (isset($_GET['info'])) { if ($_GET['info']=="favorite") {?>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>"><i class="fa fa-trash" aria-hidden="true"></i></button>

<?php } } ?>

<?php if (isset($_SESSION['user_id'])) { if ($login_u['acountType']=="admin") { ?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editID-<?php echo $Product['product_id'];?>"><i class="fa fa-pencil" aria-hidden="true"></i></button>

<div class="modal fade" id="editID-<?php echo $Product['product_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i>Edit : <?php echo $Product['product_name'];?></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body">

<img src="<?php echo $BaseUrl;?>images/products/<?php echo $Product['product_image'];?>" alt="Product" class="img-fluid" width="250">

<form method="post" enctype="multipart/form-data">

<input type="text" id="product_name" name="product_name" class="form-control" placeholder="Product Name" value="<?php echo $Product['product_name'];?>" required><br>

<input type="hidden" name="p_img" value="<?php echo $Product['product_image'];?>">

<img id="product_image2" width="200"/>
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp;Upload Image</span>
</div>
<div class="custom-file">
<input type="file" class="custom-file-input" id="productImage" name="product_image2" onchange="loadFile2(event)">
<label class="custom-file-label" for="productImage">Choose Product Image (JPEG, JPG, PNG)</label>

</div>
</div>
<br>

<div class="row mb-4">
<div class="col">
<div class="form-outline">

<select class="form-control" name="houseType" required disabled>
<option> Category "<?php echo $Product['product_category'];?>"</option>
<input type="hidden" name="p_catogry" value="<?php echo $Product['product_category'];?>">
</select>

</div>
</div>

<div class="col">
<div class="form-outline">
<input type="Number" id="price" name="product_price" class="form-control" placeholder="Price (LKR)" value="<?php echo $Product['product_price'];?>" required>
</div>
</div>
</div>

<div class="form-group">
<label for="infor">Description (0 - 500 Characters)</label>
<textarea class="form-control" id="infor" rows="3" name="infor" required><?php echo $Product['product_disc'];?></textarea>
</div>

<div class="bs-example">
<div class="clearfix">
<input type="hidden" name="p_id" value="<?php echo $Product['product_id'];?>">
<div class="pull-left"><button type="submit" class="btn btn-warning" name="UpdatePost"><i class="fa fa-upload" aria-hidden="true"></i> Update</button></div>
</div>
</div>

</form>

</div>
</div>
</div>
</div>

<a href="<?php $BaseUrl;?>items.php?category=all&DeleteProduct=<?php echo $Product['product_id'];?>" onclick="return confirm('Are You Sure?');"><button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button></a>


<?php } } else { ?>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>"><i class="fa fa-heart" aria-hidden="true"></i></button>

<?php } ?>

</ul>

</div>
</div>
</div>
</div>

<div class="modal fade" id="ViewDetails-<?php echo $Product['product_id'];?>" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $Product['product_name'];?></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<center>
<img src="<?php echo $BaseUrl;?>images/products/<?php echo $Product['product_image'];?>" alt="Product" class="img-fluid" width="250">
</center>
<br>
<p><?php echo(htmlentities($Product['product_disc']));?></p>
<hr>
<table>
<tr>
<td>PRODUCT NAME</td>
<td>:</td>
<td><?php echo $Product['product_name'];?></td>
</tr>
<tr>
<td>PRODUCT CATEGORY</td>
<td>:</td>
<td><a href="<?php echo $BaseUrl;?>items.php?category=<?php echo $Product['product_category'];?>"><?php echo $Product['product_category'];?></a></td>
</tr>
<tr>
<td><b>PRODUCT PRICE</b></td>
<td><b>:</b></td>
<td><b>Rs.<?php echo $Product['product_price'];?></b></td>
</tr>
</table>

<?php if (isset($_SESSION['user_id'])) { if ($login_u['acountType']=="admin") { ?>

<a href="<?php $BaseUrl;?>items.php?category=all&DeleteProduct=<?php echo $Product['product_id'];?>" onclick="return confirm('Are You Sure?');"><button type="button" class="btn btn-warning"><i class="fa fa-trash" aria-hidden="true"></i> Delete Product</button></a>

<?php }} ?>

<?php if (!isset($_SESSION['user_id']) OR $login_u['acountType']=="user") { ?>

<a href="<?php echo $BaseUrl;?>items.php?category=<?php echo $Product['product_category'];?>&addCart=<?php echo $Product['product_id'];?>">
<button type="button" class="btn btn-warning btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart</button>


</a>
<br>

<?php if (isset($_GET['info'])) { if ($_GET['info']=="favorite") {?>


<a href="<?php echo $BaseUrl;?>items.php?category=all&info=favorite&favDelete=<?php echo $Product['id'];?>">
<button type="button" class="btn btn-danger btn-block"><i class="fa fa-trash" aria-hidden="true"></i> Remove From Favorite</button>
</a>


<?php } } else { ?>

<a href="<?php echo $BaseUrl;?>items.php?category=<?php echo $Product['product_category'];?>&fav=<?php echo $Product['product_id'];?>">
<button type="button" class="btn btn-primary btn-block"><i class="fa fa-heart" aria-hidden="true"></i> Add To Favorite</button>
</a>


<?php } } ?>


</div>
<div class="modal-footer">
<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
</div>
</div>
</div>
</div>

<?php } }  if ($row_results == 0) { echo '<div class="card-body"><center><img src="images/noResult.png" width="600"></center></div>';} ?>
    </div>