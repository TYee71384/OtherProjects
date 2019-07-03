<?php

$id = $_GET["UID"];
require_once "../../Globals/init.php";



    $fields = array(
        "EndTime" => date('Y-m-d H:i:s'),
        "Status" => "Complete"
    );

    Update($fields, $id, "IDupdate", 'LogUpdate');

    $HistoryFields = array(
        'IDUpdate' => $id,
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy' => getUser(),
        'FileAction' => "Admin Complete",
        'Status' => "Complete");
    Create($HistoryFields, 'LogUpdateHistory');



