<?php

$id = $_GET["UID"];
require_once "../../Globals/init.php";

//get step progress
$query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id AND (Progress='Done' OR Progress='Skip')";
$count = Query($query, 1);
$count = $count->NumRec;

//get Update step Total
$query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id";
$total = Query($query, 1);
$total = $total->NumRec;


//date
$date =date('Y-m-d H:i:s');
$date =strtotime($date)+1;
$date = date('Y-m-d H:i:s',$date);

//$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
$percent = ($count / $total)*100 . '%';

if ($percent == "100%") {
    $fields = array(
        "EndTime" => date('Y-m-d H:i:s'),
        "Status" => "Complete"
    );

    Update($fields, $id, "IDupdate", 'LogUpdate');

    $HistoryFields = array(
        'IDUpdate' => $id,
        'FileTime' => $date,
        'FileBy' => getUser(),
        'FileAction' => "Complete",
        'Status' => "Complete");
    Create($HistoryFields, 'LogUpdateHistory');

} else {
    echo 'cannot complete';
}


