<?php require('../../Globals/init.php');?>
<?php

//get number of steps and add 1 for the new step
$db = new Database;

$db->query("SELECT Step FROM LogChecklistSteps WHERE IDchecklist = " . $_POST["id"] . " AND Version = " . $_POST["ver"]);
$db->execute();
$step = $db->rowCount() +1;

$fields = array(
    "IDChecklist"=>$_POST['id'],
    "Step"=>$step,
    "Version"=>$_POST['ver'],
    "StepText"=>$_POST['text']

);

  $HistoryFields = array(
        'IDchecklist'=> $_POST['id'],
        'Version' => $_POST['ver'],
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> getUser(),
        'FileAction'=> "Added a Step",
        'Status' => "Draft");
    Create($HistoryFields,'LogChecklistHistory');

Create($fields,'LogChecklistSteps');



