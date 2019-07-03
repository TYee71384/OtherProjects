<?php require('../../Globals/init.php');

$db = new Database;

$query = "DELETE FROM LogChecklistSteps WHERE IDstep= " .$_POST["StepID"];
$db->query($query);
$db->execute();


//renumber checklist steps

$array = Query("SELECT IDstep FROM LogChecklistSteps WHERE IDchecklist= ".$_GET["cid"] . " AND Version = " . $_GET["ver"]. " ORDER BY Step ASC");


$step = 1;
$field = 'Step';
$db = new Database;
$table = 'LogChecklistSteps';
$id = $_GET['cid'];
$version = $_GET['ver'];


foreach($array as $value){
 
    $query = "UPDATE $table SET $field = $step WHERE IDstep= $value->IDstep";
    $step++;
    echo $query .'<br/>';
    
    $db->query($query);
    $db->execute();

}

  $HistoryFields = array(
        'IDchecklist'=> $_POST['cid'],
        'Version' => $_POST['ver'],
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> getUser(),
        'FileAction'=> "Deleted a Step",
        'Status' => "Draft");
    Create($HistoryFields,'LogChecklistHistory');
    