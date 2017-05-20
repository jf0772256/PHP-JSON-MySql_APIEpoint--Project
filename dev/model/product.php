<?php
  //controls function for managing product pages.
  function displayProductsList(){
    //declare needed variables
    //check connection
    //get values from database
    //iterate through result set and printing them to the view products pages
    //close curser.
    global $db;
    $myConnect = get_connection_status();
    if ($myConnect == 1) {
      //run query
      //echo "<h1>Im Connected still!</h1>";
      $catList = getCategoriesList();

      for ($i=0; $i < sizeof($catList,0); $i++) {
        $val = $catList[$i]['categoryID'];
        $catList[$i]['products'] = getProductListByCat($val);
      }

      //echo var_dump($catList);
      foreach ($catList as $key=>$value) {
        //echo var_dump($value);
        echo "<h2>".$value['categoryName'].":</h2>";
        echo "<div class='row'>";
        error_reporting(0);
        foreach ($value['products'] as $key => $val) {
          //echo var_dump($val);
          $imageuri = $val['imgSmall'];
          $prodName = $val['productName'];
          $prodPrice = $val['listPrice'];
          $prodID = $val['productID'];
          echo "<div class='col-sm-3 col-md-3 col-lg-3'>
          <div class='thumbail' style='margin-top:1.5em;padding:1em;border-radius:10px;border:1px solid rgb(209, 215, 215);'>
          <img src='$imageuri' alt='$prodName' class='img-thumbnail img-responsive center-block' />
          <div class='caption'>
          <h3>$prodName</h3>
          <h4>Price: $$prodPrice</h4>
          <form method='post'>
          <input type='hidden' name='action' value='showDetailed' />
          <input type='hidden' name='productNumber' value='$prodID'/>
          <input type='submit' name='submit-$prodID' value='See Detailed Info' class='btn btn-primary btn-block' />
          </form>
          </div>
          </div>
          </div>";
        }
        error_reporting('E_ALL');
        echo "</div>";
      }
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getLargeImg($prodNum){
    //retrieves from database the string for large product images
    //escape the query,
    //build and bind the query,
    //execute the query,
    //process results,
    //return results
    global $db;
    $query="SELECT imgLrg FROM products WHERE products.productID = ?";
    $connected = get_connection_status();
    if ($connected == 1) {
      $stmnt = $db->prepare($query);
      $stmnt->bind_param("i", $prodNum);
      $stmnt->execute();
      $result = $stmnt->get_result();
      $prodImage = $result->fetch_assoc();
      $retval = $prodImage['imgLrg'];;
      return $retval;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getMedImg($prodNum){
    //retrieves from database the string for Medium product images
    //escape the query,
    //build and bind the query,
    //execute the query,
    //process results,
    //return results
    global $db;
    $query="SELECT imgMed FROM products WHERE products.productID = ?";
    $connected = get_connection_status();
    if ($connected == 1) {
      $stmnt = $db->prepare($query);
      $stmnt->bind_param("i", $prodNum);
      $stmnt->execute();
      $result = $stmnt->get_result();
      $prodImage = $result->fetch_assoc();
      $retval = $prodImage['imgMed'];;
      return $retval;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getSmallImg($prodNum){
    //retrieves from database the string for small product images
    //escape the query,
    //build and bind the query,
    //execute the query,
    //process results,
    //return results
    global $db;
    $query="SELECT imgSmall FROM products WHERE products.productID = ?";
    $connected = get_connection_status();
    if ($connected == 1) {
      $stmnt = $db->prepare($query);
      $stmnt->bind_param("i", $prodNum);
      $stmnt->execute();
      $result = $stmnt->get_result();
      $prodImage = $result->fetch_assoc();
      $retval = $prodImage['imgSmall'];;
      return $retval;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getCategoriesList(){
    //is an internal model used function
    //gets all data for categories and then places then in an array
    //then returns that to the calling function, in this case it will be displayProductsList()
    global $db;
    $query = "SELECT * FROM categories";
    $connected = get_connection_status();
    if ($connected == 1) {
      $stmnt = $db->prepare($query);
      $result = $stmnt->execute();
      $result = $stmnt->get_result();
      while ($data = $result->fetch_assoc()){
        $catData[] = $data;
      }
      return $catData;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getProductListByCat($catid){
    //gets list of categories from the database and returns the array
    //of products associated to the calling function,
    //this will also associate the images to the array.
    global $db;
    $prodByCat;
    $query="SELECT productID,
      productName,
      listPrice,
      imgSmall
    FROM products
    WHERE categoryID = ?";
    $connected = get_connection_status();
    if ($connected == 1) {
      $stmnt = $db->prepare($query);
      $stmnt->bind_param("i",$catid);
      $result = $stmnt->execute();
      $result = $stmnt->get_result();
      while($data = $result->fetch_assoc()){
        $prodByCat[] = $data;
      }
      return $prodByCat;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }
  }

  function getProductByID($prodID){
    //collects all product data from DB and packages it into an array
    //returns the product information for the product id that was passed as an parameter
    //used for product view details page.
    global $db;
    $connected = get_connection_status();
    if ($connected == 1) {
      $query = "SELECT * FROM products WHERE productID = ?";
      $stmnt = $db->prepare($query);
      $stmnt->bind_param("i", $prodID);
      $stmnt->execute();
      $result = $stmnt->get_result();
      $data[] = $result->fetch_assoc(); //only need one row value.
      return $data;
    }else{
      //not connected to database any longer... or there was a fatal error
      //Fails
      include("error/conection_timeout.php");
      exit();
    }

  }

  function parseDescription($inStringVal){
    // this formats the string maintaing original break points.
    // then for each * generate a ul and li
    // this is going to probably be the longest and most complex. functions in this project

    // $inStringVal = nl2br($inStringVal); //that males each \n and \n\r a <br />
    $inStringVal = str_replace("\r\n","\n",$inStringVal);
    $inStringVal = str_replace("\r","\n",$inStringVal);

    $paragraphs = explode("\n\n", $inStringVal);
    //echo var_dump($paragraphs);
    $outValue="";
    foreach ($paragraphs as $p) {
      $p = ltrim($p);
      $first_char = substr($p,0,1);
      if ($first_char == '*') {
        $p = '<ul>'.$p.'</li></ul>';
        $p = str_replace("*","<li>",$p); //replace * with <li>
        $p = str_replace("\n"," ",$p); //remove the ending line break.
      }else{
        $p = "<p>$p</p>";
      }
      $outValue .= $p;
    }
    return $outValue;
  }

?>
