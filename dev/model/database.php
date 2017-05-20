<?php
//Database Model for the midterm project::

//useing my_guitar_shop2 Database

$host = 'localhost';
$dbName = 'my_guitar_shop2';
$user = 'mgs_user';
$pass = 'pa55word';

@ $db = new mysqli($host, $user, $pass, $dbName);
$conn_message = $db->connect_error;
//connection status is required, exit if connection fails.
if ($conn_message != NULL) {
  include("error/connection_error.php");
  exit();
}
function get_connection_status(){
  global $db;
  return mysqli_ping($db);
}

function disp_DB_Errors ($error_message){
  global $app_path, $db;
  include("error/db_error.php");
  exit();
}
?>
