<?php
//initialize variables
$data=$error='';
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

if(!$error)
{
$search_fields = array(
'ProdLine'=>$prodLine,
'SiteKml'=>$site,
'UpdateNum'=>$update
);
 $data = search("",$search_fields,"","","","","LogUpdate");
$title = $prodLine . ' '. $site .' : Update # ' .$update;
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
?>