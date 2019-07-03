<?php require '../../Globals/init.php';?>
<?php

//$duplicate = Query("SELECT IDupdate FROM LogUpdate WHERE ProdLine='" . $_POST["ProdLine"] . "' AND SiteKml='" . $_POST["SiteKml"] . "' AND UpdateNum=" . $_POST["UpdateNum"] . " AND System='" . $_POST['System'] . "' AND Process='" . $_POST['Process'] . "' AND IDchecklist=" . $_POST['CID'] . " AND IDupdate<>" . $_POST['UID'] . " AND Status<>'Cancelled'");
$task=$updaterel=$ppack=null; 
if(!empty($_POST["Task"])) $task = $_POST["Task"];
if(!empty($_POST["UpdateNum"])) $updaterel = $_POST["UpdateNum"];
if(!empty($_POST["PPack"])) $ppack = $_POST["PPack"];

$fields = array(
    "UpdatePPack" => $ppack,
    "UpdateRelease" => $_POST["Release"],
    "Task" => $task,
    "SiteKml" => $_POST["SiteKml"],
    "UpdateNum" => $updaterel,
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
