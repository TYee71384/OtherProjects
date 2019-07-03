<?php
$id=$_GET["Uid"];
require_once("../../Globals/init.php");

//get step progress
$query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id AND (Progress='Done' OR Progress='Skip')";
$count = Query($query,1);
$count = $count->NumRec;

//get Update step Total
$query = "SELECT COUNT(*) AS NumRec FROM LogUpdateSteps WHERE IDupdate= $id";
$total = Query($query,1);
$total = $total->NumRec;

//$formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
//$percent= $formatter->format($count/$total);
$percent= ($count/$total)*100;
$percent = round($percent).'%';



    
?>
    <div class="progress-status">(<?php echo $count;?> out of <?php echo $total;?> Steps)</div>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $count?>" aria-valuemin="0" aria-valuemax="<?php echo $total;?>" style="width:<?php echo $percent;?>">
               <span class="percent"><?php echo $percent;?></span>
        </div>
       </div>
  
