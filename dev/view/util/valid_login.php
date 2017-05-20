<?php
  @session_start();
  require_once("./model/admin.php");
  $isValid = checkUserStatus();
  if (!$isValid) {
    header('HTTP/1.0 401 Unauthorized');
    include("login.php");
    exit();
  }
?>
