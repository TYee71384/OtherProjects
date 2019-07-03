<?php

//Get user based on the server, if local(Windows/Wamp) use getenv(username), if WZDE use the server variable
function getUser(){
    if($_SERVER['SERVER_NAME']== "wwwzonecode.meditech.com" || $_SERVER['SERVER_NAME']== "wzde.meditech.com")
    {

        $user = substr($_SERVER['LOGON_USER'], strpos($_SERVER['LOGON_USER'], "\\") + 1);    
        return strtoupper($user);        
      
     
    }elseif($_SERVER['SERVER_NAME']== "staff-test.meditech.com"){
        $user = substr($_SERVER['AUTH_USER'], strpos($_SERVER['AUTH_USER'], "\\") + 1);    
        return strtoupper($user); 
    }elseif($_SERVER['SERVER_NAME']== "staff.meditech.com"){
        return strtoupper($_SERVER["HTTP_COMMONNAME"]);
    }
    else{
       // return trim(getenv('username'),'$');
       //$user = explode('$',getenv('username'));
       $user = "TYEE";
       return strtoupper($user);


    }
    }
    
function getAll($table = MAIN_TABLE){
$db= new Database;
    $db->query("SELECT * from " . $table);
    $results = $db->resultset();
    return $results;
}

function getDetails($id,$id_column,$table = MAIN_TABLE){
$db = new Database;
    $db->query("SELECT * FROM " . $table . " WHERE " . $id_column. " = :id");
    $db->bind(':id',$id);
    $result = $db->single();
    return $result;

}

function getMulti($id,$id_column,$multi,$table){
  $db= new Database;
  $db->query("SELECT ".$multi. " FROM " . $table . " WHERE " . $id_column. " = :id");
  $db->bind(':id',$id);
$result = $db->resultset();
$array = array();
foreach($result as $column=>$prop)
{
  foreach($prop as $name=>$string)
  {
      $array[]=$string;
  }
}
return $array;
}

function bind($fields,$db)
{
    //Called from check function to bind the fields as needed for PDO to work
    foreach($fields as $field_name => $field)
    {
        $bind_name = ':'.$field_name;

        if($field)
        {
            $db->bind($bind_name,$field);
        }
    }
}


function like_bind($fields,$db)
{
    //Called from check function to bind the fields as needed for PDO to work
    foreach($fields as $field_name => $field)
    {
        $bind_name = ':'.$field_name;

        if($field)
        {
            $db->bind($bind_name,'%'.$field.'%');
        }
    }
}

function Query($query,$single=null)
{
    //Use this method to populate dropdowns/multiselect fields, just pass in the select query
    $db = new Database;
    $db->query($query);
    if($single){
        $results=$db->single();
    }else{
    $results = $db->resultset();}
    return $results;
}


function Autocomplete($column,$table = MAIN_TABLE)
{
    $db = new Database;
    if(isset($_GET['term'])){
        $db->query('SELECT DISTINCT ' . $column .' FROM '.$table. ' WHERE ' .$column. ' LIKE :term');
        $db->bind(':term','%'.$_GET['term'].'%');
        $results = $db->resultset();
        $array = array();
        foreach($results as $column=>$prop)
        {
            foreach($prop as $name=>$string)
            {
                $array[]=$string;
            }
        }
        echo json_encode($array);
    }
}

//testing stuff
function search($like_fields,$exact_fields=null,$multi_fields=null,$join=null,$key=null,$fkey = null,$table_name = MAIN_TABLE)
{
    /*This function requires a key/value array as the first argument
    the key is the name of the table field, and the value is what you are searching for. 2nd argument is optional, will default to the main table defined in config.php
    for example :
     $fields = array(
     "Artist" => $_GET["Artist"],
    "Label"=>$_GET["Label"]);

     NOTE: you will want to setup the key regardless if the $_GET has no value, as this method will handle checking for a value

     the other 3 fields are optional, $join is the name of the table you want to do a SQL JOIN with. if $join is defined, then $key is the primary key
     $fkey is the foreign key, if not defined, code below will assign it to the same value as $key

    $table_name will default to the constant variable defined in config.php, or you can manually create a string to override it

    Using SQL LIKE command to account for partial string lookups, so enduser does not need to type the exact name in a text field. This also works for dropdowns


    */
   
    $db = new Database;
    $query = '';
    if($like_fields)
   {
   foreach($like_fields as $field_name => $field)
   {
       $bind_name = ':'.$field_name;
       if($field)
       {
           $query .= ' AND ('.$field_name .' LIKE '. $bind_name.')';
       }
   }
   }

   if($exact_fields){
   foreach($exact_fields as $field_name => $field)
   {
       $bind_name = ':'.$field_name;
       if($field)
       {
           $query .= ' AND ('.$field_name .' = '. $bind_name.')';
       }
   }
   }

   if($multi_fields){

$in_query ='';
$comma ='';
$column_name= '';
     foreach ($multi_fields as $column => $value) {
      if($value){
$column_name = $column;
   foreach($value as $name => $string)
   {
      $in_query.= $comma.'\''.$string.'\'';
      $comma =',';
   }
   $query.= ' AND '.$column_name.' IN ';
   $query.=' ('.$in_query.') ';
          $comma='';
          $in_query='';
       
 }
         
 }
 }

   if($join)
   {
     echo $key;
       $fkey == null ? $fkey=$key : $fkey;
       $joinkey = $join. '.'.$fkey;

       $tablekey = $table_name. '.'.$key;
       $new_query= 'SELECT * FROM '. $table_name. ' LEFT JOIN ' . $join .' ON '.$joinkey. '= ' . $tablekey .' WHERE 1=1 ' . $query;
       $db->query($new_query);
   }
   else{
       $new_query ='SELECT * FROM '. $table_name. ' WHERE 1=1 ' . $query;
       $db->query($new_query);
   }

   if($like_fields){
   like_bind($like_fields,$db);}
   if($exact_fields){
     bind($exact_fields,$db);}

         $results = $db->resultset();
    $count = $db->rowCount();
         return array($results,$count);
}