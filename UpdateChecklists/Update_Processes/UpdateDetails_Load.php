<?php
function AdminComplete($id,$status){

$approvalAccess = '';
//Check to see if User has approval access to see if Admin Complete should show up
$currentUser = getUser();
$approval = Query("SELECT UserApprove FROM ListUserApprove WHERE UCase(UserApprove)='" . $currentUser . "'");
if($approval && !isset($_GET['edit'])){
     $approvalAccess = "Y";
     $query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id AND (Progress='Done' OR Progress='Skip')";
     $count = Query($query,1);
     $count = $count->NumRec;
     
     //get Update step Total
     $query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id";
     $total = Query($query,1);
     $total = $total->NumRec;

     if($count < $total && $status == "In Progress" || $status == "On Hold") {return true;}
}
 return false;
}

//get Update info
$query = "SELECT * FROM LogUpdate WHERE IDupdate=".$id;
$data = Query($query,1);

//get site name
$query = "SELECT * FROM ListSite WHERE ProdLine= '$data->ProdLine' AND SiteKml=  '$data->SiteKml'";
$name = Query($query,1);
$name = $name->SiteName;

//get history info
$query = "SELECT * FROM LogUpdateHistory WHERE IDupdate= $id ORDER BY FileTime DESC LIMIT 1";
$history= Query($query,1);

$query = "SELECT * FROM LogUpdateHistory WHERE IDupdate= $id ORDER BY FileTime ASC";
$full_history= Query($query);

//get checklist info
$query = "SELECT * FROM LogChecklist WHERE IDchecklist= $data->IDchecklist AND Version= $data->Version";
$checklist = Query($query,1);


//get steps
$query = "SELECT * FROM LogUpdateSteps WHERE IDupdate= $id ORDER BY Step";
$steps = Query($query);

function color($status){
    switch($status){
        case 'On Hold':
        case 'Cancelled':
    return 'Red';
    break;
        case 'In Progress';
            return 'Green';
            break;
        case 'Complete';
            return 'Gray';
            break;
    }
}

