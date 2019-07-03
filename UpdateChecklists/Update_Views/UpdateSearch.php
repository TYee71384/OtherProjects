<script>
$(document).tooltip();
</script>
<?php
require_once('header.php');

//Query each List table to populate dropdown selections
$platform = Query("Select ProdLine from ListProdLine");
$system = Query("Select System from ListSystem ORDER BY SortOrder");
$process = Query("Select Process from ListProcess ORDER BY SortOrder");
$release = Query("Select Rel from ListRelease");
$Site = Query("SELECT ProdLine,SiteKml FROM ListSite ORDER BY ProdLine,SiteKml");
$Ppack = Query("Select PPack from ListPPack");
$status = Query("Select Status from ListStatusUpdate ORDER BY SortOrder");
//set search params
$checklistID = '';
$version = '';
$platform_value = '';
$release_value = '';
$system_value = '';
$process_value = '';
$site_value = '';
$ppack_value = '';
$task = '';
$status_value = '';
$updateNum = '';

if (isset($_POST["search"])) {

    $checklistID = $_POST["checklistID"];
    $version = $_POST["Version"];
    $platform_value = $_POST["Platform"];
    $release_value = $_POST["Release"];
    $system_value = $_POST["System"];
    $process_value = $_POST["Process"];
    $site_value = $_POST["Site"];
    $ppack_value = $_POST["Ppack"];
    $task = $_POST["Task"];
    $status_value = $_POST["Ustatus"];
    $updateNum = $_POST["UpdateNum"];
        
        //setup fields to search on
    $search_fields = array(
        "IDChecklist" => $checklistID,
        "Version" => $version,
        "Status" => $status_value,
        "ProdLine" => $platform_value,
        "UpdateRelease" => $release_value,
        "System" => $system_value,
        "Process" => $process_value,
        "SiteKml" => $site_value,
        "UpdatePPack" => $ppack_value,
        "Task" => $task,
        "UpdateNum" => $updateNum
    );    
    
        //use check funtion to 
       // search($like_fields,$exact_fields=null,$multi_fields=null,$join=null,$key=null,$fkey = null,$table_name = MAIN_TABLE)
    $data = search("", $search_fields, "", "", "", "", "LogUpdate");



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
 <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3>Update Search</h3> </div>
        </div>
    </nav>
    <div class="container">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
               <div class="headline">
                   <h4>Update Info</h4>
               </div>
               <br>
                <div class="col-md-2 col-md-offset-1">
                    <label>Platform</label>
                      <select class="form-control" name="Platform" id="Platform">
                        <option value="">------</option>
                        <?php foreach ($platform as $ddl) : ?>
                            <option <?php if ($ddl->ProdLine === $platform_value) {
                                        echo 'selected';
                                    } ?>>
                                <?php echo $ddl->ProdLine; ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                     <label>Site</label>
                      <select class="form-control" name="Site" id="Site">
                        <option value="">------</option>
                        
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Update #</label>
                    <input type="number" min="1" class="form-control" name="UpdateNum" value="<?php echo $updateNum; ?>">
                </div>
                <div class="col-md-2">
                        <label>System</label>
                      <select class="form-control" name="System">
                        <option value="">------</option>
                        <?php foreach ($system as $ddl) : ?>
                            <option <?php if ($ddl->System === $system_value) {
                                        echo 'selected';
                                    } ?>>
                                <?php echo $ddl->System; ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                        <label>Process</label>
                      <select class="form-control" name="Process">
                        <option value="">------</option>
                        <?php foreach ($process as $ddl) : ?>
                            <option <?php if ($ddl->Process === $process_value) {
                                        echo 'selected';
                                    } ?>>
                                <?php echo $ddl->Process; ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-2">
                    <label>Task #</label>
                    <input type="number" min="1" class="form-control" name="Task" value="<?php echo $task; ?>">
                </div>
                <div class="col-md-2">
                    <label>Update Release</label>
                       <select class="form-control" name="Release">
                        <option value="">------</option>
                        <?php foreach ($release as $ddl) : ?>
                            <option <?php if ($ddl->Rel === $release_value) {
                                        echo 'selected';
                                    } ?>>
                                <?php echo $ddl->Rel; ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>PPack</label>
                       <select class="form-control" name="Ppack">
                        <option value="">------</option>
                        <?php foreach ($Ppack as $ddl) : ?>
                            <option <?php if ($ddl->PPack === $ppack_value) {
                                        echo 'selected';
                                    } ?>>
                                <?php echo $ddl->PPack; ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Update Status</label>
                       <select class="form-control" name="Ustatus">
                        <option value="">------</option>
                        <?php foreach ($status as $ddl) : ?>
                            <option <?php if ($ddl->Status === $status_value) {
                                        echo 'selected';
                                    } ?>>
                                <?php echo $ddl->Status; ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="headline">
                    <h4>Checklist</h4>
                </div>
                <br>
                <div class="col-md-2 col-md-offset-3">
                    <label>
                        Checklist ID
                    </label>
                    <input type="number" class="form-control" min=1 name="checklistID" value="<?php echo $checklistID; ?>">
                </div>
                 <div class="col-md-2 col-md-offset-2">
                    <label>
                       Version
                    </label>
                    <input type="number" min="1" class="form-control" name="Version" value="<?php echo $version; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                 <div class="col-md-offset-5">
                  <input type="submit" class="btn btn-primary" name="search" value="Search">
                    <input type="reset" class="btn btn-danger" name="reset" value="Reset" onclick="window.location.href='UpdateSearch.php'">
                </div>
            </div>
        </form>
    </div>
       <?php if (isset($_POST['search'])) {
            if ($data[0]) {
                ?>
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>PL</th>
                        <th>Site</th>
                        <th>Update #</th>
                        <th>System</th>
                        <th>Process</th>
                        <th>Task</th>
                        <th>Release</th>
                        <th>PPack</th>
                        <th>CID</th>
                        <th>Version</th>
                        <th>Start Date</th>
                        <th>Last Activity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="highlight">
                    <?php foreach ($data[0] as $match) : ?>
                  <?php  $query = "SELECT * FROM LogUpdateHistory WHERE IDupdate= $match->IDupdate ORDER BY FileTime DESC LIMIT 1";
                             $lastuser = Query($query,1);?>
                  <?php  $query = "SELECT * FROM LogUpdateHistory WHERE IDupdate= $match->IDupdate ORDER BY FileTime ASC LIMIT 1";
                             $startuser = Query($query,1);?>
                        <tr class=<?php echo str_replace(' ', '',$match->Status);?>>
                            <td>
                                <?php echo $match->ProdLine; ?>
                            </td>
                            <td>
                                <?php echo $match->SiteKml; ?>
                            </td>
                            <td>
                                <?php echo $match->UpdateNum; ?>
                            </td>
                            <td>
                                <?php echo $match->System; ?>
                            </td>
                            <td>
                                <?php echo $match->Process; ?>
                            </td>
                            <td>
                                <?php echo $match->Task; ?>
                            </td>
                            <td>
                                <?php echo $match->UpdateRelease; ?>
                            </td>
                            <td>
                                <?php echo $match->UpdatePPack; ?>
                            </td>
                              <td>
                                <?php echo $match->IDchecklist; ?>
                            </td>
                            <td>
                                <?php echo $match->Version; ?>
                            </td>
                              <td title="<?php if(!empty($startuser)) echo "Started By ".$startuser->FileBy?>">
                                <?php if ($match->StartTime != null) : ?>
                               <?php echo date('m/d/Y', strtotime($match->StartTime)); ?>
                               <?php endif; ?>
                            </td>
                            <td title="<?php if(!empty($lastuser)) echo "Last User ".$lastuser->FileBy?>">             
                              <?php if ($match->EndTime != null){
                                echo date('m/d/Y', strtotime($match->EndTime));
                              }else{
                                $query = "SELECT * FROM LogUpdateHistory WHERE IDupdate= $match->IDupdate ORDER BY FileTime DESC LIMIT 1";
                                $history = Query($query,1);
                                if(!empty($history))
                                echo date('m/d/Y', strtotime($history->FileTime));
                              }?>
                               
                               
                            </td>
                    
                              <td>
                                <?php if ($match->Status == "In Progress" || $match->Status == "On Hold") : ?>
                                  <a target="_blank" href="UpdateDetails.php?UID=<?php echo $match->IDupdate; ?>&edit=true"><?php echo $match->Status . " " . GetPercentage($match->IDupdate); ?></a>
                                  <?php else : ?>
                                 <a target="_blank" href="UpdateDetails.php?UID=<?php echo $match->IDupdate; ?>"><?php echo $match->Status; ?></a>
                                  <?php endif; ?>          
                            </td>
                           
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
              <h3 class="text-center">Records found: <?php echo $data[1]; ?></h3>
            <?php 
        } else {

            echo '<div class="row"><div class="container col-md-12"><h3 class="text-center">No Results Found</h3></div></div>';
        }
    } ?>
    <script>
$(document).ready(function(){
    $("#Platform").change(function(){
        var platform = $('#Platform').val();
        console.log(platform);
        $.ajax({
            type:"POST",
            url: "../Update_Processes/GetSite.php",
            data: "platform="+platform,
            success: function(data){
               $('#Site').html(data);
               
            }
        
        })
    })
});
</script>