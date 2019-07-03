<?php $title ="Checklist Search";
require_once('header.php');

//Query each List table to populate dropdown selections
$platform = Query("Select ProdLine from ListProdLine");
$system = Query("Select System from ListSystem ORDER BY SortOrder");
$process = Query("Select Process from ListProcess ORDER BY SortOrder");
$release = Query("Select Rel from ListRelease");
$type = Query("Select Type from ListType ORDER BY SortOrder");
$status = Query("Select Status from ListStatusChecklist ORDER BY SortOrder");
//set search params

//setup initial variables
$checklistID ='';
$version ='';
$status_value ='Approved';
$platform_value ='';
$release_value ='';
$type_value ='';
$system_value ='';
$process_value ='';

    if(isset($_POST["search"])){
  
   $checklistID = $_POST["checklistID"];
$version =$_POST["Version"];
$status_value = $_POST["Status"];
$platform_value = $_POST["Platform"];
$release_value = $_POST["Release"];
$type_value =$_POST["Type"];   
$system_value = $_POST["System"];
$process_value = $_POST["Process"];
        

        
        //setup fields to search on
   $search_fields = array(
        "IDChecklist"=> $checklistID,
       "Version"=>$version,
        "Status"=>$status_value,
       "ProdLine"=>$platform_value,
       "Rel"=>$release_value,
       "Type"=>$type_value,
       "System"=>$system_value,
       "Process"=>$process_value
    );    
    
        //use check funtion to 
    $data = search("",$search_fields);
        

}


?>
   <?php if(isset($_GET['delete'])): ?>
   <script>
      toastr.options.timeOut=3000;
    toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.error('Checklist Deleted');
</script>
   <?php endif;?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3>Checklist Search</h3> </div>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form"> <a href="ChecklistBuilder.php" class="btn btn-default">Create New Checklist</a> </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="col-md-offset-1">
                <div class="col-md-3 col-md-offset-1">
                    <label>Checklist ID</label>
                    <input type="number" min=1 name="checklistID" class="form-control" placeholder="Checklist ID" value="<?php echo $checklistID;?>"> </div>
                <div class="col-md-3 col-md-offset-1 form-group">
                    <label>Version</label>
                    <input type="number" min=1 name="Version" class="form-control" placeholder="Version" value="<?php echo $version;?>"> </div>
                <div class="col-md-2 col-md-offset-1 form-group">
                    <label>Status</label>
                    <select class="form-control" name="Status">
                        <option value="">------</option>
                        <?php foreach($status as $ddl): ?>
                            <option <?php if($ddl->Status === $status_value){echo 'selected';} ?>>
                                <?php echo $ddl->Status;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <br> </div>
            <br>
            <div class="col-md-offset-2">
                <div class="col-md-2">
                    <label>Platform</label>
                    <select class="form-control" name="Platform">
                        <option value="">------</option>
                        <?php foreach($platform as $ddl): ?>
                            <option <?php if($ddl->ProdLine === $platform_value){echo 'selected';} ?>>
                                <?php echo $ddl->ProdLine;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>System</label>
                    <select class="form-control" name="System">
                        <option value="">------</option>
                        <?php foreach($system as $ddl): ?>
                            <option <?php if($ddl->System === $system_value){echo 'selected';} ?>>
                                <?php echo $ddl->System;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label>Process</label>
                    <select class="form-control" name="Process">
                        <option value="">------</option>
                        <?php foreach($process as $ddl): ?>
                            <option <?php if($ddl->Process === $process_value){echo 'selected';} ?>>
                                <?php echo $ddl->Process;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label>Release</label>
                    <select class="form-control" name="Release">
                        <option value="">------</option>
                        <?php foreach($release as $ddl): ?>
                            <option <?php if($ddl->Rel === $release_value){echo 'selected';} ?>>
                                <?php echo $ddl->Rel;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label>Type</label>
                    <select class="form-control" name="Type">
                        <option value="">------</option>
                        <?php foreach($type as $ddl): ?>
                            <option <?php if($ddl->Type === $type_value){echo 'selected';} ?>>
                                <?php echo $ddl->Type;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <br/>
            <div class="col-md-offset-5">
                <div class="col-md-6">
                    <input type="submit" class="btn btn-primary" name="search" value="Search">
                    <input type="reset" class="btn btn-danger" name="reset" value="Reset" onclick="window.location.href='ChecklistSearch.php'"> </div>
            </div>
        </form>
        <?php if (isset($_POST['search'])) {
         if ($data[0]) {
             ?>
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>CID</th>
                        <th>Version</th>
                        <th>Status</th>
                        <th>Title</th>
                        <th>PL</th>
                        <th>System</th>
                        <th>Process</th>
                        <th>Release</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody class="highlight">
                    <?php foreach($data[0] as $match) : ?>
                        <tr class="<?php echo $match->Status;?>">
                            <td> <a target="_blank" href="ChecklistDetails.php?cid=<?php echo $match->IDchecklist.'&ver='.$match->Version;?>"><?php echo $match->IDchecklist;?></a> </td>
                            <td>
                                <?php echo $match->Version?>
                            </td>
                            <td>
                                <?php echo $match->Status?>
                            </td>
                            <td>
                                <?php echo $match->Title?>
                            </td>
                            <td>
                                <?php echo $match->ProdLine?>
                            </td>
                            <td>
                                <?php echo $match->System?>
                            </td>
                            <td>
                                <?php echo $match->Process?>
                            </td>
                            <td>
                                <?php echo $match->Rel?>
                            </td>
                            <td>
                                <?php echo $match->Type?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                </tbody>
            </table>
              <h3 class="text-center">Records found: <?php echo $data[1];?></h3>
            <?php } else {
                 
        echo '<div class="row"><div class="container col-md-12"><h3 class="text-center">No Results Found</h3></div></div>';
    } } ?>