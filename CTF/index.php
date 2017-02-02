<?php
include 'userfunctions.php';
include 'database.php';
include 'ctffunction.php';
include 'loadquestion.php';
session_start();
//Initalize
$uerr="";
$ruerr="";
$perr="";
$rperr="";
$cperr="";
$emerr="";
$uname=$pass=$cpass=$email="";
$runame="";
//Ans Verification Section
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Submit"]))
{
  $uid=test_input($_SESSION["id"]);
  $qid=test_input($_POST["qid"]);
  $flag=test_input($_POST["flag"]);
  $result=verify($qid,$flag);
  if($result==1)
  {
    questinanswered($uid,$qid);
    $emerr="WOW YOU GOT IT RIGHT";
  }
  else {
    $emerr="INVALID FLAG";
  }
}

//Login Section
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"]))
{
  $flag=1;
if(!isset($_POST["username"]) || $_POST["username"] =="")
{$uerr="USERNAME CANNOT BE EMPTY";$flag=0;}
if(!isset($_POST["pass"]) || $_POST["pass"] == "")
{
  $perr="PASSWORD CANNOT BE EMPTY";
  $flag=0;
}
$uname=test_input($_POST["username"]);
$pass=test_input($_POST["pass"]);
$uid=getUser($uname);
if($uid ==-1)
{
  $uerr="INVALID USERNAME";
}
else
{
$pass=verify_pass($uid,$pass);
if($pass)
{
  //Valid User LOGIN AND SET THE COOKIE
  $_SESSION["id"]=$uid;
}
else {
  $perr="INVALID PASSWORD";
}
}
}//End of Login
//Register Section
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"]))
{
//Check If UserName Already Taken
$flag=1;//Everything is OKAY
$runame=test_input($_POST["username"]);
if($runame==""||$runame==NULL)
{
  $flag=0;
  $ruerr="USERNAME CANNOT BE EMPTY";
}
$remail=test_input($_POST["email"]);
if($remail=="" || $remail==NULL)
{
  $flag=0;
  $emerr="EMAIL CANNOT BE EMPTY";
}
else if (!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
  $flag=0;
  $emerr = "INVALID EMAIL FORMAT";
}
$pass=test_input($_POST["pass"]);
if($pass=="" || $pass==NULL)
{
  $flag=0;
  $perr="PASSWORD CANNOT BE BLANK";
}
$cpass=test_input($_POST["cpass"]);
if($cpass != $pass)
{
  $perr="ENTER THE PASSWORD AGAIN";
  $cperr="PASSWORD DONNOT MATCH";
  $flag=0;
  $pass="";

}
$uid=getUser($runame);//Check UserName is already taken
if($uid!=-1)
{
  $ruerr="USERNAME ALREADY EXIST";
  $flag=0;
}
$uid=getEmail($remail);//Check if the User is Already Registered
if($uid !=-1)
{
  $emerr="EMAIL ALREADY TAKEN";
  $flag=0;
}
//If Everything is Okay add the User to the DataBase
if($flag)
{
  $r=adduser($runame,$remail,$pass);//ADD TO DATABASE
  if($r)
  $cperr="USER REGISTRATION SUCCESSFUL";
  else {
    $cperr="ERROR WHILE ADDING THE USER";
  }
}




}

?>
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
    ?>
      <h3 "text-center">Login </h3>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="form-group">
        <input class="form-control" type="text" placeholder="USERNAME" name="username" value="<?php echo $uname; ?>"
        />
        <label style="color:red;"><?php echo $uerr; ?> </label>
      </div><div class="form-group">
        <input class="form-control" type="password" placeholder="PASSWORD" name="pass"/>
        <label style="color:red;"><?php echo $perr; ?> </label>
      </div><div class="form-group">
      <input class="btn btn-primary btn-block" type="submit" name="login" value="Login"/>
    </div>
      </form><!--LOGIN FORM -->
    </div><!--Login-->
    <?php if(isset($_POST["register"])){ ?>
    <div id="reg" class="tab-pane fade in active">
      <?php }
      else {
        ?>
        <div id="reg" class="tab-pane fade">

      <?php } ?>
    <h3 "text-center">Register   </h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <div class="form-group">
      <input class="form-control" type="text" placeholder="USERNAME" name="username" value="<?php echo $runame; ?>"/>
      <label style="color:red;"><?php echo $ruerr; ?> </label>
    </div>
    <div class="form-group">
    <input class="form-control" type="email" placeholder="EMAIL" name="email"value="<?php echo $remail; ?>"/>
    <label style="color:red;"><?php echo $emerr; ?> </label>
  </div>
    <div class="form-group">
      <input class="form-control" type="password" placeholder="PASSWORD" name="pass"/>
      <label style="color:red;"><?php echo $rperr; ?> </label>
    </div>
    <div class="form-group">
      <input class="form-control" type="password" placeholder="CONFIRM PASSWORD" name="cpass"/>
      <label style="color:red;"><?php echo $cperr; ?> </label>
    </div>
    <div class="form-group">
    <input class="btn btn-primary btn-block" type="submit" name="register" value="Register"/>
    <div><!--Register -->
    </div><!--tab-content -->
</div><!--Pannel Body -->
</div><!--Pannel -->
</div>
<?php } ?>
</body>
</html>
