<?php
// navigation short page, This will allow users to navigate the pages here in.
// uses bootstrap::navigation
?>

<!-- make seperate from the pages container -->
<div class="container">
  <!-- default nav bar from getbootstrap.com -->
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">MyGuitarShop</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <form class="navbar-form" method="post">
          <input type="hidden" name="action" value="viewproducts">
          <input type="submit" name="submitme" value="Products" class="btn btn-default btn-lrg">
        </form>
        <!-- additional menus that can be used later -->
        <!-- <li><a href="#">Link</a></li>
        <li><a href="#">Link</a></li> -->

        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li> -->
      </ul>

      <!-- <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form> -->

      <ul class="nav navbar-nav navbar-right">
        <?php if (checkUserStatus()) {
          echo "<li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Admin Access <span class='caret'></span></a>
            <ul class='dropdown-menu'>
              <form method='post'>
              <input type='hidden' name='action' value='viewallorders' />
              <button type='submit' class='btn btn-default btn-block'>View Orders</button>
              </form>
              <li role='separator' class='divider'></li>
              <li><form method='post'><input type='hidden' name='action' value='logout' /><input type='submit' name='logout' value='Log Out' class='btn btn-primary btn-block' /></form></li>
            </ul>
          </li>";
        }else{
          echo "<form method='post' class='navbar-form'>
            <input type='hidden' name='action' value='login' />
            <input type='submit' name='gotoLogin' value='Log In' class='btn-lrg btn btn-primary' />
          </form>";
        } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
