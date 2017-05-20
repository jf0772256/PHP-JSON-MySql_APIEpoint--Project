<?php
  //model for controlling orders and their functions.

  function getAllOrdersList(){
    //queries db and returns array of results to main orders page
    //ping db connection test is still active,
    //if active then send select query to database table
    //process results into an array
    //return processed resluts to calling body
    global $db;
    $connected = get_connection_status();
    if ($connected == 1) {
      $query = "SELECT orders.orderID, CONCAT_WS(' ',customers.firstName,customers.lastName) AS 'custName', customers.emailAddress, orders.orderDate FROM orders,customers WHERE orders.customerID = customers.customerID";
      $stmnt = $db->prepare($query);
      $stmnt->execute();
      $result = $stmnt->get_result();
      while($data = $result->fetch_assoc()){
        $ordersData[] = $data;
      }
      return $ordersData;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getUnsentOrdersList(){
    //queries db and returns array of results to main orders page
    //ping db connection test is still active,
    //if active then send select query to database table
    //process results into an array
    //return processed resluts to calling body
    global $db;
    $connected = get_connection_status();
    if ($connected == 1) {
      $query = "SELECT orders.orderID, CONCAT_WS(' ',customers.firstName,customers.lastName) AS 'Name', orders.orderDate FROM orders,customers WHERE orders.customerID = customers.customerID AND orders.shipDate IS Null";
      $stmnt = $db->prepare($query);
      $stmnt->execute();
      $result = $stmnt->get_result();
      while ($data = $result->fetch_assoc()){
        $ordersData[] = $data;
      }
      return $ordersData;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function showDetailedUnsentOrder($orderIDval){
    //queries db and returns array of result to view_order page
    //ping db connection test is still active,
    //if active then send select query to database table
    //process results into an array
    //return processed resluts to calling body
    global $db;
    $connected = get_connection_status();
    if ($connected == 1) {
      $query = "SELECT orders.orderID, CONCAT_WS(' ',customers.firstName,customers.lastName) AS 'Name', CONCAT_WS(' ',addresses.line1,addresses.line2,addresses.city,addresses.state,addresses.zipCode) AS 'Address', products.productName FROM orders,customers,addresses,orderitems,products WHERE orders.customerID = customers.customerID AND orders.shipAddressID = addresses.addressID AND orders.orderID = orderitems.orderID AND orderitems.productID = products.productID AND orders.orderID = ?";
      $stmnt = $db->prepare($query);
      $stmnt->bind_param('i',$orderIDval);
      $stmnt->execute();
      $result = $stmnt->get_result();
      while ($data = $result->fetch_assoc()){
        $ordersData[] = $data;
      }
      return $ordersData;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getOrderDetails($orderIDval){
    //queries db and returns array of result to view_order page
    //ping db connection test is still active,
    //if active then send select query to database table
    //process results into an array
    //return processed resluts to calling body
    global $db;
    $connected = get_connection_status();
    if ($connected == 1) {
      $query = "SELECT orders.orderID, orders.orderDate, orders.shipDate, orders.taxAmount, orders.shipAmount, orders.cardNumber, products.productName, products.listPrice, products.discountPercent, CONCAT_WS(' ',addresses.line1,addresses.line2,addresses.city,addresses.state,addresses.zipCode) AS 'Address', orderitems.discountAmount, orderitems.quantity FROM orders,products,orderitems,addresses WHERE orders.orderID = orderitems.orderID AND orderitems.productID = products.productID AND orders.billingAddressID = addresses.addressID AND orders.orderID = ?";
      $stmnt = $db->prepare($query);
      $stmnt->bind_param('i',$orderIDval);
      $stmnt->execute();
      $result = $stmnt->get_result();
      while ($data = $result->fetch_assoc()){
        $ordersData[] = $data;
      }
      return $ordersData;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getCardType($cardNumber){
    //takes card number and processes and returns a value based on card number data
    //3 = Amex, 4 = Visa, 5 = MC, 6 = Discover
    $cardiVal = substr($cardNumber,0,1);
    if ($cardiVal == 3) {
      return "AmEx";
    }elseif ($cardiVal == 4) {
      return "Visa";
    }elseif ($cardiVal == 5) {
      return "MasterCard";
    }elseif ($cardiVal == 6) {
      return "DiscoverCard";
    }else{
      return "Unknown Card Type";
    }
  }
?>
