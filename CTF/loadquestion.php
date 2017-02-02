<?php
function display()
{
$xml=simplexml_load_file("question.xml") or die("Error: Cannot create object");
foreach($xml->children() as $q)
{
  $qid=$q->qid;
  $title=$q->title;
  $data=$q->data;
  $score=$q->score;
//For div and style
?>
<div class="container well">
<div class="panel panel-default">
  <div class="panel-header">
<?php echo $title."-".$score."<br>";?>
</div>
<div class="panel-body">
<?php echo $data."<br>";?>
</div>
<?php
$f=alreadyans($_SESSION["id"],$qid);
if(!$f)
{
  ?>
  <div class="panel-footer">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
<input class="form-control" type="text" placeholder="Enter the Flag Here" name="flag"/>
<input type="hidden" value="<?php echo $qid;?>" name="qid"/>
<input type="submit" class="btn btn-primary btn-block" value="Submit" name="Submit"/>
</form>
<?php
}
else {
  ?>
  <div class="alert alert-success">
    <strong> Correct Answer Submitted</strong>
  </div>
<?php
}
?>
</div>
</div>
</div>
<?php  }
}
?>
