<?php
  //view to see a listing of all orders.
  require_once("util/valid_login.php");
  include("view/partial/_head.php");
?>

<div class="jumbotron">
  <h1>View Product Orders</h1>
</div>
<!-- this is simply to show that the page works! -->
<h2>Product Orders List:</h2>
<div class="row">
  <div class="col-sm-3 col-md-3 col-lrg-3">
    <!-- Header->Name -->
    <h3>Customer Name:</h3>
  </div>
  <div class="col-sm-3 col-md-3 col-lrg-3">
    <!-- Header->EmailAddress -->
    <h3>Customer Email:</h3>
  </div>
  <div class="col-sm-3 col-md-3 col-lrg-3">
    <!-- Header->OrderDate -->
    <h3>Order Date:</h3>
  </div>
  <div class="col-sm-3 col-md-3 col-lrg-3">
    <!-- Header->viewOrder -->
    <h3>&nbsp;</h3>
  </div>
</div>
<hr />
<div class="row">
  <?php
    $allOrders = getAllOrdersList();
    // echo var_dump($allOrders);
    foreach ($allOrders as $key => $value) {
      $orderidnumber = $value['orderID'];

      echo "<div class='col-sm-3 col-md-3 col-lrg-3'>";
      echo $value['custName'];
      echo "</div>";

      echo "<div class='col-sm-3 col-md-3 col-lrg-3'>";
      echo $value['emailAddress'];
      echo "</div>";

      echo "<div class='col-sm-3 col-md-3 col-lrg-3'>";
      echo $value['orderDate'];
      echo "</div>";

      echo "<div class='col-sm-3 col-md-3 col-lrg-3'>";
      echo "<form method='post'><input type='hidden' name='action' value='vieworder' /><input type='hidden' name='orderidval' value='$orderidnumber' /><input type='submit' name='submitbtn' value='View Order' class='btn btn-primary btn-block btn-lrg' /></form>";
      echo "</div>";
    }
  ?>
</div>
<hr />
<h2>Un-Shipped Orders List:</h2>
<div class="row">
  <div class="col-sm-4 col-md-4 col-lrg-4">
    <!-- Header->Name -->
    <h3>Customer Name:</h3>
  </div>
  <div class="col-sm-4 col-md-4 col-lrg-4">
    <!-- Header->OrderDate -->
    <h3>Order Date:</h3>
  </div>
  <div class="col-sm-4 col-md-4 col-lrg-4">
    <!-- Header->viewOrder -->
    <h3>&nbsp;</h3>
  </div>
</div>
<hr />
<div class="row">
  <?php
    $unShipped = getUnsentOrdersList();
    // echo var_dump($unShipped);
    foreach ($unShipped as $key => $value) {
      $orderidnumber = $value['orderID'];
      echo "<div class='col-sm-3 col-md-3 col-lrg-3'>";
      echo $value['Name'];
      echo "</div>";

      echo "<div class='col-sm-3 col-md-3 col-lrg-3' style='text-align:right;padding-right:3.8em;'>";
      echo $value['orderDate'];
      echo "</div>";

      echo "<div class='col-sm-3 col-md-3 col-lrg-3'>";
      echo "&nbsp;";
      echo "</div>";

      echo "<div class='col-sm-3 col-md-3 col-lrg-3'>";
      echo "<form method='post'><input type='hidden' name='action' value='viewUSOrderDet' /><input type='hidden' name='orderidval' value='$orderidnumber' /><input type='submit' name='submitbtn' value='View Order' class='btn btn-primary btn-block btn-lrg' /></form>";
      echo "</div>";
    }
  ?>
</div>

<?php include("view/partial/_footer.php"); ?>
