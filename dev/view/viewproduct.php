<?php include("partial/_head.php"); ?>
<!-- single product detail page  -->

<?php
  //get product details and have them in array productInfo
  $productInfo = getProductByID($selected);
  // echo var_dump($productInfo);
  foreach ($productInfo as $key) {
    $name = $key['productName'];
    $desc = $key['description'];
    $price = $key['listPrice'];
    $discount = $key['discountPercent'];
    $savings = number_format(($price * ($discount/100)),2);
    $afterdisc = number_format(($price - ($price * ($discount / 100))),2);
  }
?>
<div class="row">
  <div class="col-sm-3 col-md-3 col-lg-3">
    <img src="<?php echo getMedImg($selected); ?>" alt="" class="img-responsive img-thumbnail center-block">
    <button type="button" name="showModalImage" class="btn btn-default btn-lrg center-block" style="margin-top:.75em;" data-toggle="modal" data-target="#modlimg">View Larger</button>
  </div>
  <div class="col-sm-9 col-md-9 col-lg-9">
    <h3><?php echo $name; ?></h3>

    <h4>Description:</h4>
    <?php echo parseDescription($desc); ?>

    <h4>Price: <?php echo "$$price"; ?></h4>

    <h4>Discount Percent: <?php echo "$discount% ($$savings Savings)"; ?></h4>

    <h4>Price after savings!: <?php echo "$$afterdisc"; ?></h4>

    <form method="post">
      <input type="hidden" name="action" value="viewproducts">
      <input type="submit" name="submit" value="Back to Products" class="btn btn-primary btn-lrg">
    </form>
  </div>
</div>

<!-- modal image box -->
<div class="modal fade" id="modlimg" tabindex="-1" role="dialog" aria-labelledby="imageModalDisplay">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style="text-align:center;"><?php echo $name; ?></h4>
      </div>
      <div class="modal-body">
        <img src="<?php echo getLargeImg($selected); ?>" alt="<?php echo $name; ?>" class="img-responsive img-thumbnail center-block">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-lrg center-block" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include("partial/_footer.php"); ?>
