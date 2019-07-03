<?php

//get id from url
$id = $_GET["cid"];

//TODO: Write actual code to identify user
$currentUser = getUser();
//$currentUser = "SGOULART";
//declare variables
$approvalAccess=$allowApprove=$allowDelete=$allowDraft=$allowArchive=$data=$version=$allowEdit=$allowStarter=$scope_error ="";
//check if version is set
if(isset($_GET["ver"])){
    
$version = $_GET["ver"];
$data = Query("SELECT * FROM LogChecklist WHERE IDchecklist=".$id. " AND Version=".$version,1);
}else
{
    //get all data depending on the proper version    
    $query = "SELECT * FROM LogChecklist WHERE IDchecklist=" . $id . " ORDER BY Status ASC"; 
   // $db->query($query);
    $results = Query($query);
    
    foreach($results as $result)
    {
        switch($result->Status)
        {
                case 'Approved';
                $version = $result->Version;
                $data =$result;
                break 2;
                case 'Draft';
                $version = $result->Version;
                $data=$result;
                break 2;
                case 'Archived';
                $version = $result->Version;
                $data = $result;
                break;             
        }
    }

}
//get Activity info
$query = "SELECT * FROM LogChecklistHistory WHERE IDchecklist=" . $data->IDchecklist . " AND Version=" . $version . " ORDER BY FileTime DESC LIMIT 1";
$history = Query($query,1);

$lastActivity = $history->FileTime;
$lastUser = $history->FileBy;

//Check to see if User has approval access
$approval = Query("SELECT UserApprove FROM ListUserApprove WHERE UCase(UserApprove)='" . $currentUser . "'");
if($approval){
     $approvalAccess = "Y";}

//check to display Draft button
if($data->Status == "Approved" && $approvalAccess == "Y")
{
    //If Draft already exists, do not display button
    $draftQuery = Query("SELECT Status FROM LogChecklist WHERE IDchecklist=" . $data->IDchecklist . " AND Status='Draft'");
    if(!$draftQuery){$allowDraft ="Y";}  
}

//check to display Archive button
if($data->Status == 'Approved' && $approvalAccess =="Y")
{
    //make sure Draft version does not exist
    if(!$draftQuery){$allowArchive ="Y";}
}

//check to display delete buttons
if ($data->Status == "Draft")
{
    $allowDelete ="Y";
}

//check to display edit button
if($data->Status == "Draft" && $approvalAccess)
{
    $allowEdit = "Y";
}

//check to dispaly Approve
if($data->Status == "Draft" && $approvalAccess && $currentUser!=$lastUser)
{
    if(!isset($data->Scope) || $data->Scope == "")
    {
    $scope_error = "Objective & Scope is required in order to Approve";
    $allowApprove = "N";
    }
    else
    {
        $allowApprove = "Y";
    }
   
}

//check to display Update Starter
if($data->Status == "Approved")
{
    $allowStarter = "Y";
}

//get steps
$steps = Query("SELECT * FROM LogChecklistSteps WHERE IDchecklist=" . $data->IDchecklist . " AND Version=" . $data->Version . " ORDER BY Step");

//get document Control
$documentControl=Query("SELECT * FROM LogChecklistHistory WHERE IDchecklist=" . $data->IDchecklist . " AND Version=" . $data->Version . " AND Status='Approved' ORDER BY FileTime DESC LIMIT 1",1);

//get color based on status
function color($status){
    switch($status){
        case 'Archived';
    return 'gray';
    break;
        case 'Approved';
            return 'Green';
            break;
        case 'Draft';
            return 'Red';
            break;
    }
}