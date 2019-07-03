<?php require('../../Globals/init.php');?>
<?php 
$updateNum=$task=$release=$PPack=null;
$id = $_POST["CID"];
$version = $_POST["Ver"];
$site = $_POST["SiteKml"];
if(!empty($_POST["Task"])) $task = $_POST["Task"];
if(!empty($_POST["Release"])) $release = $_POST["Release"];
if(!empty($_POST["PPack"])) $PPack = $_POST["PPack"];
$updateNum = $_POST["UpdateNum"];
$ProdLine = $_POST["ProdLine"];
$system = $_POST["System"];
$process = $_POST["Process"];



//check for duplicate
$query = "SELECT IDupdate FROM LogUpdate WHERE ProdLine='$ProdLine' AND SiteKml='$site' AND UpdateNum=$updateNum AND System='$system' AND Process='$process' AND IDchecklist=$id AND Status<>'Cancelled'";
$error = Query($query,1);

if($error)
{
    $msg = "$ProdLine $site Update # $updateNum $system $process already exists. Please try again. <br>";
     echo json_encode(array('message' => $msg));
}else{


//create update 
$update_fields = array(
"ProdLine"=>$ProdLine,
"SiteKml"=>$site,
"UpdateNum"=>$updateNum,
"System"=>$system,
"Process"=>$process,
"Task"=>$task,
"UpdateRelease"=>$release,
"UpdatePPack"=>$PPack,
"IDchecklist"=>$id,
"Version"=>$version,
"Status"=>"In Progress",
"StartTime"=>date('Y-m-d H:i:s')
);
    
    
$updateId = Create($update_fields,"LogUpdate");

$db = new Database;
$query = "INSERT INTO LogUpdateSteps (IDupdate,Step,StepText) SELECT $updateId,Step,StepText FROM LogChecklistSteps WHERE IDChecklist = $id AND Version= $version ORDER BY Step";
$db->query($query);
$db->execute();

//Create($step_fields,'LogUpdateSteps');
    
$HistoryFields = array(
        'IDupdate'=> $updateId,
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> getUser(),
        'FileAction'=> "Start Update",
        "Status"=> "In Progress");
        
    Create($HistoryFields,'LogUpdateHistory');    
    
 
echo json_encode(array('done' => $updateId));    
    
    
}

   


