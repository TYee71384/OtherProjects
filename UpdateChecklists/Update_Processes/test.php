<?php
$id=$_GET["Uid"];
require_once("../../Globals/init.php");

//get step progress
$query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id AND (Progress='Done' OR Progress='Skip')";
$count = Query($query,1);
$count = $count->NumRec;

//get Update step Total
$query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id";
$total = Query($query,1);
$total = $total->NumRec;

//$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
//$percent= $formatter->format($count/$total);
$percent=($count/$total);
echo json_encode($percent);