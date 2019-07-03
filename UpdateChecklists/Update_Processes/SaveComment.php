<?php require('../../Globals/init.php');?>
<?php
$comment = $_POST["Comment"];
$id = $_POST["IDupdate"];
$step = $_POST["Step"];
$db = new Database;
$query = "UPDATE LogUpdateSteps SET Comment =:comment WHERE IDupdate = :id AND Step= :step";
$db->query($query);
$db->bind(':comment',$comment);
$db->bind(':id',$id);
$db->bind(':step',$step);
$db->execute();
//var_dump($_POST);