<?php require('../../Globals/init.php');?>
<?php
$id=$step=$version='';

$id=$_POST['cid'];
$version = $_POST["version"];
$step = $_POST["step"];

//var_dump($_POST);
if($id){
$details = Query("SELECT * FROM LogChecklistSteps WHERE IDchecklist = " .$id . " AND Step =".$step. " AND Version=".$version,1);
//var_dump($details);
//echo text info;
echo json_encode($details);    
}

