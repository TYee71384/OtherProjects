<?php require('../../Globals/init.php');?>
<?php


$step = 1;
$field = 'Step';
$db = new Database;
$table = 'LogChecklistSteps';



foreach($_POST['step'] as $value){
 
    $query = "UPDATE $table SET $field = $step WHERE IDstep=$value";
  //  echo $query;
    $step++;

    $db->query($query);
    $db->execute();

}