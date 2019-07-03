<?php require('../../Globals/init.php');


//get ID from Post request
$id = $_POST["cid"];
$version = $_POST["ver"];

$SQL = "SELECT Status FROM LogChecklist WHERE IDchecklist=" .$id. " AND Version=" .$version;
$status = Query($SQL,1);
$status = $status->Status;
$db = new Database;
//TODO:: get user info

if($status == 'Draft')
{
    //Delete Version from LogChecklist table
    $query = "DELETE FROM LogChecklist WHERE IDchecklist=" . $id . " AND Version=" . $version;
    $db->query($query);
    $db->execute();
    
    //Delete Steps from LogChecklistSteps table
	$query = "DELETE FROM LogChecklistSteps WHERE IDchecklist=" .$id. " AND Version=" . $version;
	$db->query($query);
    $db->execute();
	
	//Delete History from LogChecklistHistory table
	$query = "DELETE FROM LogChecklistHistory WHERE IDchecklist=" . $id. " AND Version=" .$version;
	$db->query($query);
    $db->execute();
    //delete index if checklist is first version
    if($version==1){
        $query = "DELETE FROM LogChecklistIndex WHERE IDchecklist=" . $id;
        $db->query($query);
    $db->execute();
        
    }
}
header("Location: ../Checklist_views/ChecklistSearch.php?delete=true");
exit();

?>

