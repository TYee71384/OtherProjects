<?php require('../../Globals/init.php');?>
<?php

$fields = array(
    "StepText"=>$_POST['step']

);

Update($fields,$_POST['StepID'],"IDstep",'LogChecklistSteps');

  $HistoryFields = array(
        'IDchecklist'=> $_POST['cid'],
        'Version' => $_POST['ver'],
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> getUser(),
        'FileAction'=> "Edited Step",
        'Status' => "Draft");
    Create($HistoryFields,'LogChecklistHistory');



