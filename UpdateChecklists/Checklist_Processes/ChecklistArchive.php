<?php require('../../Globals/init.php');


//get ID from Post request
$id = $_POST["cid"];
$version = $_POST["ver"];

$SQL = "SELECT Status FROM LogChecklist WHERE IDchecklist=" .$id. " AND Version=" .$version;
$status = Query($SQL,1);
$status = $status->Status;
$error ="";


//TODO:: get user info
//$user = getUser();
if($status == "Approved"){
    //Check if Draft version exists
		$query = "SELECT Status FROM LogChecklist WHERE IDchecklist=" . $id. " AND Status='Draft'";
    $draft = Query($query);
    if($draft){
       $error = "Cannot archive when there is a Draft version";
    }
}else {
    $error= "Invalid Status";
}

if(!$error){
    $db = new Database;
    $query = "UPDATE LogChecklist SET Status='Archived' WHERE IDchecklist=" . $id . " AND Version=" . $version . " AND Status='" . $status . "'";
    $db->query($query);
    $db->execute();
    
    //File History for current version
    $HistoryFields = array(
        'IDchecklist'=> $id,
        'Version' => $version,
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> getUser(),
        'FileAction'=> "Marked as Archived",
        'Status' => "Archived");
        
    Create($HistoryFields,'LogChecklistHistory');
}

header("Location: ../Checklist_views/ChecklistDetails.php?cid=".$id.'&Ver='.$version);
exit();
