<?php require('../../Globals/init.php');?>
<?php
$comment = $_POST["Comment"];
$id = $_POST["IDupdate"];
$step = $_POST["Step"];
$status = urldecode($_POST['Status']);
$db = new Database;
$query = "UPDATE LogUpdateSteps SET Comment =:comment, Progress='Skip' WHERE IDupdate = :id AND Step= :step";
$db->query($query);
$db->bind(':comment',$comment);
$db->bind(':id',$id);
$db->bind(':step',$step);
$db->execute();
var_dump($_POST);

    $HistoryFields = array(
        'IDupdate'=> $id,
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> getUser(),
        'Status'=> $status,
        'FileAction'=> "Skipped Step $step");
        
    Create($HistoryFields,'LogUpdateHistory');