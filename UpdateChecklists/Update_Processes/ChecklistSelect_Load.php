<?php
//initialize variables
//Task=712345678&Rel=5.67&PP=9
$result=$data=$error=$task=$rel=$ppack='';
$error = array();
//query string variables
if(isset($_GET["PL"]) && $_GET['PL']!=null)
{
$prodLine = $_GET["PL"];
}else {    
array_push($error,"Platform is missing");}
if(isset($_GET["Site"]) && $_GET['Site']!=null)
{
$site = $_GET["Site"];
}else
{
    array_push($error,"Site is missing");
}
if(isset($_GET["Upd"]) && $_GET['Upd']!=null)
{
$update = $_GET["Upd"];
}else
{
    array_push($error,"Update number is missing");
}

if(isset($_GET["Sys"]) && $_GET['Sys']!=null)
{
$system = $_GET["Sys"];
}else
{
    array_push($error,"System is missing");
}

if(isset($_GET["Proc"]) && $_GET['Proc']!=null)
{
$process = $_GET["Proc"];
}else
{
    array_push($error,"Process is missing");
}
if(!empty($_GET["PP"]))
{
    $ppack = $_GET["PP"];
    if(strlen($ppack)==1)
        $ppack = '0'.$ppack;
}
if(!empty($_GET["Task"]))
{
    $task = $_GET["Task"];
    
}
if(!empty($_GET["Rel"]))
{
    $rel = $_GET["Rel"];
    
}

if(!$error)
{
$search_fields = array(
'ProdLine'=>$prodLine,
'SiteKml'=>$site,
'UpdateNum'=>$update,
'System'=>$system,
'Process'=>$process 
);
 $data = search("",$search_fields,"","","","","LogUpdate");
$title = $prodLine . ' '. $site .' : Update # ' .$update . ' : ' . $process;

    if($data[1]==1)
{
        $id ='';
    foreach($data[0] as $match)
    {
        $id=$match->IDupdate;
    }
    header("Location: ../Update_Views/UpdateDetails.php?UID=$id&edit=true");
}
    elseif($data[1]==0)
    {
        $query = "SELECT * FROM LogChecklist WHERE ProdLine='$prodLine' AND System='$system' AND Process='$process' AND Status='Approved' ORDER BY IDchecklist,Version";
        $result = Query($query);
        
      //  var_dump($result);
    }
    else
    {
        $result = $data[0];
    }
    
    
}
else
{
    foreach($error as $e)
    {
        echo '<div class=text-center><b class="error">'.$e.'</b></div></br>';
    }
    $title = 'Error';
}


function GetPercentage($id)
{
        //get step progress
    $query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id AND (Progress='Done' OR Progress='Skip')";
    $count = Query($query, 1);
    $count = $count->NumRec;

//get Update step Total
    $query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id";
    $total = Query($query, 1);
    $total = $total->NumRec;

    //$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
   // return $percent = $formatter->format($count / $total);
   $percent= ($count/$total)*100;
    return round($percent).'%';

}