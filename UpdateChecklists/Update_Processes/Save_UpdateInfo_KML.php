<?php require '../../Globals/init.php';?>
<?php
$task=$updatenum=null; 
if(!empty($_POST["Task"])) $task = $_POST["Task"];
if(!empty($_POST["UpdateNum"])) $updatenum = $_POST["UpdateNum"];
$fields = array(
    "UpdatePPack" => $_POST['PPack'],
    "UpdateRelease" => $_POST["Release"],
    "Task" => $task,
    "SiteKml" => $_POST["SiteKml"],
    "UpdateNum" => $updatenum,
    "Note" => $_POST["Note"],
    "Status" => $_POST["Status"]

);

Update($fields, $_POST['UID'], "IDupdate", 'LogUpdate');

$HistoryFields = array(
    'IDupdate' => $_POST['UID'],
    'FileTime' => date('Y-m-d H:i:s'),
    'FileBy' => getUser(),
    'FileAction' => "Updated General Information",
    'Status' => $_POST["Status"]);

Create($HistoryFields, 'LogUpdateHistory');
