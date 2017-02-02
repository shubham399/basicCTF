<?php
function gethash($data)
{
  $hash=hash("sha256",$data);
  //Generate a Hash for the Input
  return $hash;
}

$flag="Ceremonial plates";
echo gethash($flag);

 ?>
