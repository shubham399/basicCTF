<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"]))
{
  $uid=test_input($_SESSON["id"]);
  $qid=test_input($_POST["qid"]);
  $flag=test_input($_POST["flag"]);
  $result=verify($qid,$flag);
  echo $result;
  if($result==1)
  {
    questinanswered($uid,$qid);
    $emerr="WOW YOU GOT IT RIGHT";
    echo $emerr;
  }
  else {
    $emerr="INVALID FLAG";
  }
}
 ?>
