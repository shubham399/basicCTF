<?php include 'global.php';?>
 <!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="./css/bootstarp.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>Basic CTF</title>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Basic CTF</a>
    </div>
<?php if(isset($_SESSION["id"]))    {?>
    <div class="form-group">
      <ul class="nav navbar-nav navbar-right">
       <li><a href="logout.php">Logout</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
      <li><a href="#">Your Score is  <?php $score=getscore($_SESSION["id"]); echo " ".$score;?></a></li>
    </ul>
    </div>
    <?php } ?>
  </div>
</nav>
<?php
if(isset($_SESSION["id"]))
{
  display();
}
else { ?>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
  <h3 class="text-center">Login/Register</h3>
  <ul class="nav nav-tabs">
    <?php  if(!isset($_POST["register"]))
    {
    ?>
    <li class="active"><a data-toggle="tab" href="#login">Login</a></li>
    <li><a data-toggle="tab" href="#reg">Register </a></li>
    <?php
  } else { ?>
    <li><a data-toggle="tab" href="#login">Login</a></li>
    <li class="active"><a data-toggle="tab" href="#reg">Register </a></li>
  <?php }?>
  </ul>
    <div class="tab-content">
      <?php  if(!isset($_POST["register"]))
      {
      ?>
      <div id="login" class="tab-pane fade in active">
      <?php
    }
    else { ?>
      <div id="login" class="tab-pane fade">
  <?php  }
      get_loginform();
     if(isset($_POST["register"])){ ?>
    <div id="reg" class="tab-pane fade in active">
      <?php }
      else {
        ?>
        <div id="reg" class="tab-pane fade">

      <?php } get_registerform(); ?>
    </div><!--tab-content -->
</div><!--Pannel Body -->
</div><!--Pannel -->
</div>
<?php } ?>
</body>
</html>
