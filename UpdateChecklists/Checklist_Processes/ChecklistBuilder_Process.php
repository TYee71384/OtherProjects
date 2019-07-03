<?php require('../../Globals/init.php');?>
<?php

if (isset($_POST['create'])){
    

 //Insert into LogChecklistIndex to get Id for LogChecklist;
     $IndexFields = array(
         'CreatedBy'=> getUser(),
         'CreatedTime' => date('Y-m-d H:i:s'));
         $newId = Create($IndexFields,'LogChecklistIndex');
    
    //Insert into LogChecklist
    $LogFields = array(
        'IDchecklist'=> $newId,
        'Version' => 1,
        'Status' => "Draft",
        'Title' => $_POST['Title'],
        'ProdLine'=> $_POST['Platform'],
        'System' => $_POST['System'],
        'Process'=> $_POST['Process'],
        'Rel'=> $_POST['Release'],
        'Type'=> $_POST['Type']
    );
    Create($LogFields);
  
    //Create Steps (until a better solution is in place)
    
    
    $HistoryFields = array(
        'IDchecklist'=> $newId,
        'Version' => 1,
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> getUser(),
        'FileAction'=> "Create new Checklist Version",
        'Status' => "Draft");
        
    Create($HistoryFields,'LogChecklistHistory');
    
  
};
?>
<form id="form" method="post" action="../Checklist_Views/ChecklistEditor.php">
<input type="hidden" name="cid" value="<?php echo $newId;?>">
<input type="hidden" name="ver" value="1">
</form>
<script> document.getElementById('form').submit()</script>
<?php
//header("Location: ../Checklist_Views/ChecklistEditor.php?cid=".urlencode($newId));
//exit();
?>

