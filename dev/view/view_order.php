<?php
  // view to see specific order details
  require_once("util/valid_login.php");
  include("view/partial/_head.php");
  global $viewValue;
  $viewAction="viewallorders";
?>

<div class="jumbotron">
  <h1>View Order #<?php echo $ordernumber; ?></h1>
</div>

<h2>Order Number: <?php echo $ordernumber; ?></h2>

<?php
  if ($viewValue === "detailedview") {
    //displays the full order details.
    $details = getOrderDetails($ordernumber);
    //echo var_dump($details);
      $od = $details[0]['orderDate'];
      $sd = $details[0]['shipDate'];
      if ($sd == null || $sd == '') {
        $sd = "Order Not Yet Shipped";
      }
      $tax = $details[0]['taxAmount'];
      $SA = $details[0]['shipAmount'];
      $CN = $details[0]['cardNumber'];
      $adr = $details[0]['Address'];
      $ct = getCardType($CN);

      echo "<div class='row'>
      <div class='col-sm-3 col-md-3 col-lrg-3' style='font-weight:bold;'>Billing Address:</div>
      <div class='col-sm-5 col-md-5 col-lrg-5' style='text-align:center;'>$adr</div>
      <div class='col-sm-2 col-md-2 col-lrg-2' style='font-weight:bold;text-align:center;'>Card Type Used:</div>
      <div class='col-sm-2 col-md-2 col-lrg-2' style='text-align:center;'>$ct</div>
      </div><hr />
      <div class='row'>
      <div class='col-sm-3 col-md-3 col-lrg-3' style='font-weight:bold;'>Order Date:</div>
      <div class='col-sm-3 col-md-3 col-lrg-3' style='text-align:center;'>$od</div>
      <div class='col-sm-3 col-md-3 col-lrg-3' style='font-weight:bold;text-align:center;'>Ship Date:</div>
      <div class='col-sm-3 col-md-3 col-lrg-3' style='text-align:center;'>$sd</div>
      </div><hr />
      <div class='row'>
      <div class='col-sm-2 col-md-2 col-lrg-2' style='font-weight:bold;'>Card Number:</div>
      <div class='col-sm-2 col-md-2 col-lrg-2' style='text-align:center;'>$CN</div>
      <div class='col-sm-2 col-md-2 col-lrg-2' style='font-weight:bold;text-align:center;'>Shipping:</div>
      <div class='col-sm-2 col-md-2 col-lrg-2' style='text-align:center;'>$$SA</div>
      <div class='col-sm-2 col-md-2 col-lrg-2' style='font-weight:bold;text-align:center;'>Tax:</div>
      <div class='col-sm-2 col-md-2 col-lrg-2' style='text-align:center;'>$$tax</div>
      </div>";
      echo "<hr />";
    $ost = 0.00;
    $ot = 0.00;
    $st = 0.00;
    echo "<div class='row'>
      <div class='col-sm-3 col-md-3 col-lrg-3'>
      <h3 style='text-align:center;'>Product Name:</h3>
      </div>
      <div class='col-sm-2 col-md-2 col-lrg-2'>
      <h3 style='text-align:center;'>List Price:</h3>
      </div>
      <div class='col-sm-2 col-md-2 col-lrg-2'>
      <h3 style='text-align:center;'>Discount %:</h3>
      </div>
      <div class='col-sm-2 col-md-2 col-lrg-2'>
      <h3 style='text-align:center;'>Discount $:</h3>
      </div>
      <div class='col-sm-1 col-md-1 col-lrg-1'>
      <h3 style='text-align:center;'>Quantity:</h3>
      </div>
      <div class='col-sm-2 col-md-2 col-lrg-2'>
      <h3 style='text-align:center;'>Line Total:</h3>
      </div>
    </div><hr />";
    foreach ($details as $key => $value) {
      $pn = $value['productName']; //3
      $lp = $value['listPrice']; //2
      $dp = $value['discountPercent'];//2
      $da = $value['discountAmount'];//2
      $qnty = $value['quantity'];//1
      $st = ($lp - $da) * $qnty;//2
      $dst = number_format($st,2);
      $ost += $st;
      $dost = number_format($ost,2);
      // 3 2 2 2 1 2 = 12 all good
      echo "<div class='row'>
        <div class='col-sm-3 col-md-3 col-lrg-3'>
        <p style='text-align:center;'>$pn</p>
        </div>
        <div class='col-sm-2 col-md-2 col-lrg-2'>
        <p style='text-align:center;'>$$lp</p>
        </div>
        <div class='col-sm-2 col-md-2 col-lrg-2'>
        <p style='text-align:center;'>$dp%</p>
        </div>
        <div class='col-sm-2 col-md-2 col-lrg-2'>
        <p style='text-align:center;'>$$da</p>
        </div>
        <div class='col-sm-1 col-md-1 col-lrg-1'>
        <p style='text-align:center;'>$qnty</p>
        </div>
        <div class='col-sm-2 col-md-2 col-lrg-2'>
        <p style='text-align:center;'>$$dst</p>
        </div>
      </div><hr />";
    }
    $ot = $ost + $SA + $tax;
    echo "<div class='row'>
    <div class='col-sm-3 col-md-3 col-lrg-3'>&nbsp;</div>
    <div class='col-sm-2 col-md-2 col-lrg-2' style='text-align:center;font-weight:bold;padding-left:6em;'><p>Sub Total:</p></div>
    <div class='col-sm-1 col-md-1 col-lrg-1' style='text-align:center;'>$$dost</div>
    <div class='col-sm-1 col-md-1 col-lrg-1' style='text-align:center;font-weight:bold;'><p>Shipping:</p></div>
    <div class='col-sm-1 col-md-1 col-lrg-1' style='text-align:center;'>$$SA</div>
    <div class='col-sm-1 col-md-1 col-lrg-1' style='text-align:center;font-weight:bold;'><p>Tax:</p></div>
    <div class='col-sm-1 col-md-1 col-lrg-1' style='text-align:center;'>$$tax</div>
    <div class='col-sm-1 col-md-1 col-lrg-1' style='text-align:center;font-weight:bold;'><p>Total:</p></div>
    <div class='col-sm-1 col-md-1 col-lrg-1' style='text-align:center;'>$$ot</div>
    </div><hr />";
  }elseif ($viewValue === "unshipped") {
    //displays full order details for unshipped orders
    $details = showDetailedUnsentOrder($ordernumber);
    //echo var_dump($details);
    $cust_name = $details[0]['Name'];
    $cust_addr = $details[0]['Address'];
    echo "<span style='font-weight:bold;'>Customer Name:</span> $cust_name<br />";
    echo "<span style='font-weight:bold;'>Shipping Address:</span> $cust_addr<br />";
    echo "<span style='font-weight:bold;'>Products on Order:</span><br />";
    foreach ($details as $key => $value) {
      //print out a list of products on the order.
      $product = $value['productName'];
      echo "<div class='row'><div class='col-sm-2 col-md-2 col-lrg-2'></div><div class='col-sm-10 col-md-10 col-lrg-10'>$product</div></div>";
    }
  }else{
    echo "Invalid Value: Exiting Script.";
  }
?>

<form method="post">
  <input type="hidden" name="action" value="<?php echo $viewAction; ?>">
  <input type="submit" name="goback" value="Back to All Orders" class="btn btn-primary btn-lrg">
</form>

<?php include("view/partial/_footer.php"); ?>
