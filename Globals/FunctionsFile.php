<?php
function Create($fields,$table = MAIN_TABLE){
$db = new Database;
  $insert = '';
  $query ='';
  $values ='';
  $comma = '';

  foreach($fields as $field_name => $field) {
    $bind_name = ':'.$field_name;
    $insert .= $comma.$field_name;
    $values .= $comma.$bind_name ;
$comma = ',';
  }
  $query .= "INSERT INTO ". $table."(".$insert .") VALUES (".$values.")";
  $db->query($query);

  foreach($fields as $field_name => $field){
      $bind_name = ':'.$field_name;
      $db->bind($bind_name,$field);
  }
$db->execute();
return $db->lastInsertId();

}


function Update($fields,$id,$id_name,$table = MAIN_TABLE)
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
    $query .= ' WHERE ' . $id_name . ' = ' . $id_bind;
    $db->query($query);

    foreach($fields as $field_name => $field)
    {
        $bind_name = ':'.$field_name;
        $db->bind($bind_name,$field);
    }
    $db->bind($id_bind,$id);
    $db->execute();
}


function UpdateMulti($multi,$multi_name,$id,$id_name,$table_name){
    $db = new Database;
    $id_bind = ':'.$id_name;
    $delete = 'DELETE FROM ' . $table_name . ' WHERE ' . $id_name .' = '. $id_bind;
    $db->query($delete);
    $db->bind($id_bind,$id);
    $db->execute();

    if($multi)
    {
        $q = 'INSERT INTO ' .$table_name. '('.$id_name.','.$multi_name.') VALUES('. $id_bind.',:single)';
        $db->query($q);
        foreach($multi as $single){
            $db->bind($id_bind,$id);
            $db->bind(':single',$single);
            $db->execute();
        }
    }
}
