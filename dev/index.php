<?php
// Mid term project -- PHP CIS239-101
//written by:: Jesse Fender
//date:: 03/22/2017

//$host = 'localhost';
//$dbName = 'my_guitar_shop2';
//$user = 'mgs_user';
//$pass = 'pa55word';

//includes and requires::
require("model/database.php");
require("class/API.php"); // api test
require("model/admin.php");
require("model/product.php");
require("model/order.php");
session_start();
if (!isset($_SESSION['isValidUser'])) {$_SESSION['isValidUser'] = false;}
//variable declaration::
$pageTitle ="";
$LogInMessage = null;
if(isset($_POST)){$action = filter_input(INPUT_POST,'action',FILTER_DEFAULT);}

  if ($action === NULL ||$action === ""){

    //api test here//
      $filename = "test_api";
      $filepath = "files/api";
      $myQuery = "SELECT * FROM categories";
      $newHost = "localhost";
      $newUser = "mgs_user";
      $newPassword = "pa55word";
      $dbName = "my_guitar_shop2";

      $api = new JsonifyMySQLRequests($myQuery,$filename,$filepath,$newHost,$newUser,$newPassword,$dbName);
      $connectionTest = $api->checkDBC();
      if ($connectionTest == 1) {
        echo "Connected successfully!<br />";
        echo $api->getFilePath() . "/" . $api->getFilename();
        echo "<p id='demo'></p>";
      }
      $generatedAPI = $api->parseRequests()->jsonifyResults()->writeJSON('a');//->closeConnection();
      //echo $api->readJSONFile();
      $api->setFileName('products');
      $api->setQuery("SELECT * FROM products");
      $generatedAPI = $api->parseRequests()->jsonifyResults()->writeJSON('a')->closeConnection();
      if ($api->checkDBC() == 0) {
        echo "API CLASS: I have closed successfully.";
      }
    //end api test here//


    //loads homepage if action returns no value
    $pageTitle = "Home";
    include("view/main.php");
  }elseif ($action === "login") {
    $pageTitle = "Log In";
    include("view/login.php");
  }elseif ($action === "logout") {
    $_SESSION['isValidUser'] = false;
    $pageTitle = "Home";
    include("view/main.php");
    session_destroy();
  }elseif ($action === "processLogin") {
    if ($_POST['username']!="" && $_POST['password'] !="") {
      //doing the login verification here - more than actually doung auth...
      // checks against hard coded values - Not good practice but thats not what i am doing it for.
      $userPassword = filter_input(INPUT_POST,'password',FILTER_DEFAULT); //user supplied password
      $userUsername = filter_input(INPUT_POST,'username',FILTER_DEFAULT); //user supplied username

      $result = processUserLogin($userUsername,$userPassword);

      if ($result) {
        // $loggedIn = true;
        $pageTitle = "Home - Admin";
        include("view/main.php");
      } else {
        $LogInMessage = "The username or password didn't match our records.";
        $pageTitle = "Log In";
        include("view/login.php");
      }

    }else{
      $LogInMessage = "There was an empty value in either your username or password. Please retry.";
      $pageTitle = "Log In";
      include("view/login.php");
  }
}elseif($action === "viewallorders"){

  //protected page

  $pageTitle = "View Order List";
  include("view/vieworders.php");

}elseif($action === "vieworder"){
  //protected page
  $ordernumber = $_POST['orderidval'];
  $viewValue = "detailedview";
  $pageTitle = "View Order #" . $ordernumber;
  include("view/view_order.php");

}elseif ($action === "viewUSOrderDet") {
  //protected page
  $ordernumber = $_POST['orderidval'];
  $viewValue = "unshipped";
  $pageTitle = "View Pending Order #" . $ordernumber;
  include("view/view_order.php");

}elseif ($action === "viewproducts") {
  $pageTitle = "View Products";
  include("view/productsPage.php");

}elseif ($action == "showDetailed") {
  $selected = filter_input(INPUT_POST,'productNumber',FILTER_VALIDATE_INT);
  $prodval = getProductByID($selected);
  //echo var_dump($prodval);
  $pageTitle = $prodval[0]['productName'];
  unset($prodval);
  include("view/viewproduct.php");

}else {
  $action = '' ;
  include("view/main.php");
}

?>
