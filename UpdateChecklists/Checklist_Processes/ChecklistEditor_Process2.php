<?php require('../../Globals/init.php');?>
<?php

     $fields = array(
        'Title' => $_POST['Title'],
        'ProdLine'=> $_POST['Platform'],
        'System' => $_POST['System'],
        'Process'=> $_POST['Process'],
        'Rel'=> $_POST['Release'],
        'Type'=> $_POST['Type'],
         'Scope'=>$_POST['Scope']
    );
    
    UpdateFields($fields,$_POST['cid'],"IDchecklist",$_POST['ver']);
    
    $HistoryFields = array(
        'IDchecklist'=> $_POST['cid'],
        'Version' => $_POST['ver'],
        'FileTime' => date('Y-m-d H:i:s'),
        'FileBy'=> getUser(),
        'FileAction'=> "Edited Description",
        'Status' => "Draft");
    Create($HistoryFields,'LogChecklistHistory');

function UpdateFields($fields,$id,$id_name,$version,$table = MAIN_TABLE)
{
    $db = new Database;
    $query = 'UPDATE ' . $table . ' SET ';
    $id_bind = ':'.$id_name;
    $i = 0;
    $length = count($fields)-1;
    foreach($fields as $field_name => $field)
    {
        $bind_name = ':'.$field_name;
        $query .= $field_name . ' = ' . $bind_name;
        $i < $length  ? $query .= ', ' : ' ';
        $i++;
    }
    $query .= ' WHERE ' . $id_name . ' = ' . $id_bind . ' AND Version = :Version';
    $db->query($query);
    foreach($fields as $field_name => $field)
    {
        $bind_name = ':'.$field_name;
        $db->bind($bind_name,$field);
    }
    $db->bind($id_bind,$id);
     $db->bind(':Version',$version);
    $db->execute();
}