<?php include("partial/_nonNavHead.php"); ?>
<div class="container">
  <div class="container-fluid">

    <div class="panel panel-default" style="margin:10em auto 5em;width:45em;">
      <div class="panel-heading">
        <h3>Log In to the Administration Panel</h3>
      </div>
      <div class="panel-body">
        <!-- display Fail message here -->
        <?php
          if (!empty($LogInMessage) || $LogInMessage != Null) {
            echo "<div class='alert alert-danger'><p>";
            echo $LogInMessage;
            echo "</p></div>";
            $LogInMessage = Null;
          }else{
            echo "";
          }
        ?>
        <form class="form-horizontal" method="post">
          <div class="form-group">
            <input type="hidden" name="action" value="processLogin">
          </div>
          <div class="form-group">
            <label for="username" class="control-label" style="margin-left:2.25em;">Username:</label>
            <input type="text" name="username" value="" placeholder="Enter your username" class="form-control" style="width:90%; margin:0 auto;">
          </div>
          <div class="form-group">
            <label for="password" class="control-label" style="margin-left:2.25em;">Password:</label>
            <input type="password" name="password" value="" class="form-control" style="width:90%; margin:0 auto;">
          </div>
          <div class="form-group">
            <span style="margin-left:2.5em;">&nbsp;</span>
            <input type="submit" name="processLogin" value="LogIn" class="btn btn-primary btn-lrg" style="padding:1em 5em;">
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<?php include("partial/_footer.php"); ?>
