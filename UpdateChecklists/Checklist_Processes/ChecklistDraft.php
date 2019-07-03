<?php require '../../Globals/init.php';

//get ID from Post request
$id = $_POST["cid"];
$version = $_POST["ver"];
$status = $_POST["status"];

$error = '';

//TODO:: Get User information

//check missing info
if ($id == '' || $version == '') {
    $error = "Missing Info";
}

//Check Status
if ($status != "Approved") {
    $error = "Invalid Status";
}

//Check if Darft version already exists
$SQLfind = "SELECT Status FROM LogChecklist WHERE IDchecklist=" . $id . " AND Status='Draft'";
$results = Query($SQLfind);
if ($results) {
    $error = "Draft Already Exists";
}

//Copy data into new version
if (!$error) {

    //get current record
    $query = "SELECT * FROM LogChecklist WHERE IDchecklist=" . $id . " AND Version=" . $version . " AND Status='" . $status . "'";
    $result = Query($query, 1);
    $newVersion = $version + 1;
    $fields = array(
        'IDchecklist' => $id,
        'Version' => $newVersion,
        'Status' => "Draft",
        'Title' => $result->Title,
        'ProdLine' => $result->ProdLine,
        'System' => $result->System,
        'Process' => $result->Process,
        'Rel' => $result->Rel,
        'Scope' => $result->Scope,
        'Type' => $result->Type,
    );

    Create($fields);

    $steps = Query("SELECT * FROM LogChecklistSteps WHERE IDchecklist=" . $id . " AND Version=" . $version . " ORDER BY Step");
    foreach ($steps as $step) {
        $StepsFields = array(
            'IDchecklist' => $id,
            'Version' => $newVersion,
            'Step' => $step->Step,
            'StepText' => $step->StepText);

        Create($StepsFields, 'LogChecklistSteps');
    }

    $HistoryFields = array(
        'IDchecklist' => $id,
        'Version' => $newVersion,
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy' => getUser(),
        'FileAction' => "Create new Checklist Version",
        'Status' => "Draft");

    Create($HistoryFields, 'LogChecklistHistory');
}
header("Location: ../Checklist_Views/ChecklistDetails.php?cid=$id&ver=$newVersion");
exit();
