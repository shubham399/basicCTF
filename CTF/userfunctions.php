<?php
function getUser($username)
{
  $username=test_input($username);
  $conn=get_connection();//Get Database connection
  $sql="SELECT `uid` FROM `user` WHERE `username`='$username'";
  $result = $conn->query($sql);
  $conn->close();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row["uid"];
    }
else {
    return -1;
}
}
function verify_pass($uid,$password)
{
  $uid=test_input($uid);
  $password=gethash(test_input($password));
  $conn=get_connection();//Get Database connection
  $sql="SELECT `uid` FROM `user` WHERE `uid`='$uid' and `hash`='$password'";
  $result = $conn->query($sql);
$conn->close();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return 1;
    }
  else {
    return 0;
  }


}

//Get Score for the USERNAME
function getscore($uid)
{
  $uid=test_input($uid);
  $conn=get_connection();
  $sql ="SELECT `score` FROM `user` WHERE `uid`='$uid'";
  $result=$conn->query($sql);
$conn->close();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $r=$row["score"];
    return $r;
    }
  else {
    return -1;
  }
}
function getEmail($email)
{
  $email=test_input($email);
  $conn=get_connection();
  $sql="SELECT `uid` FROM `user` WHERE `email`='$email'";
  $result=$conn->query($sql);
  $conn->close();
  if($result->num_rows >0)
  {
    return $row["uid"];
  }
  else {
    return -1;
  }
}
function adduser($uname,$email,$pass)
{
  $uname=test_input($uname);
  $email=test_input($email);
  $pass=gethash(test_input($pass));
  $conn=get_connection();
  $sql = "INSERT INTO `user` (`username`,`hash`,`email`) VALUES ('$uname','$pass','$email')";
  if(($result=$conn->query($sql))==TRUE)
  {
    $conn->close();
    return 1;
  }
  else {
    $conn->close();
    return 0;
  }
}
?>
