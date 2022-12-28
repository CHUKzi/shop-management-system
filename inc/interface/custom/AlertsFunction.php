<?php
if (!empty($suces)) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> <?php echo $suces;?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } if (!empty($warnings)) { 

  foreach ($warnings as $warning) {
    if (!empty($warning)) { 
  ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo $warning;?>

<?php if (!isset($warningClose)) {?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
<?php } ?>

</div>
<?php } } }if (!empty($errors)) {?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> <?php echo $errors; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>