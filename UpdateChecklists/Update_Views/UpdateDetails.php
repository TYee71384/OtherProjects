<?php
$id=$_GET["UID"];
require_once('header.php');
require_once('../Update_Processes/UpdateDetails_Load.php');
if(isset($_GET["edit"])){echo '<script>var $edit='.json_encode($_GET["edit"]).';</script>';}
else{echo '<script>var $edit=false</script>';}
echo '<script> var $id='. json_encode($id) . '</script>';
echo '<script> var $status='. json_encode($data->Status) . '</script>';
echo '<script> var $process='. json_encode($data->Process) . '</script>';
echo '<script> var $sys='. json_encode($data->System) . '</script>';
echo '<script> var $prodLine='. json_encode($data->ProdLine) . '</script>';
echo '<script> var $checklistId='. json_encode($checklist->IDchecklist) . '</script>';

if(($data->Status == "Complete" || $data->Status =="Cancelled") && isset($_GET['edit']))
{
    header("Location: UpdateDetails.php?UID=$id");
}


$system = Query("Select System from ListSystem ORDER BY SortOrder");
$process = Query("Select Process from ListProcess ORDER BY SortOrder");
$release = Query("Select Rel from ListRelease");
$Site = Query("SELECT ProdLine,SiteKml,SiteName FROM ListSite WHERE ProdLine = '$data->ProdLine' ORDER BY ProdLine,SiteKml");
$Ppack = Query("Select PPack from ListPPack");
$status = Query("Select Status from ListStatusUpdate WHERE Status <>'Complete' ORDER BY SortOrder ");


?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3><?php echo $data->ProdLine;?>
 <?php echo $data->SiteKml;?> : <?php if(!empty($data->UpdateNum)) : ?>  Update # <?php echo $data->UpdateNum;?> : <?php endif;?> <?php echo $data->Process;?></h3> </div>
                <ul class="nav navbar-nav" style="color:<?php echo Color($data->Status);?>">
                    <li class="padding-li"><h3><?php echo $data->Status;?></h3></li>
                    <li class="padding-li" id="ProgressBar">
                    </li>
                </ul>
            <ul class="nav navbar-nav navbar-right">
                <li> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><b class="caret"></b></a>
                    <div class="dropdown-menu">
                        <div> <b>Start Time: </b>
                            <?php echo $data->StartTime;?>
                        </div>
                        <div> <b>Last Activity: </b>
                            <?php echo $history->FileTime;?>
                        </div>
                        <div> <b>Last User: </b>
                            <?php echo $history->FileBy;?>
                        </div>
                    </div>
                </li>
                <li class="history-link">
                    <form method="post" class="navbar-form" action="UpdateHistory.php?UID=<?php echo $id;?>">
                        <input type="submit" class="btn btn-default" value="View History"> </form>
                </li>
                <?php if($data->Status !="Complete" && $data->Status !="Cancelled" && !isset($_GET['edit'])):?>
                <li>
                   <form method="post" class="navbar-form" action='UpdateDetails.php?UID=<?php echo $data->IDupdate?>&edit=true'>
                        <input type="submit" class="btn btn-primary" value="Edit"> </form>
                </li>

                <?php endif;?>
                <?php if(isset($_GET["edit"])):?>
                <li>
                   <form method="post" class="navbar-form" action='UpdateDetails.php?UID=<?php echo $data->IDupdate?>'>
                        <input type="submit" class="btn btn-default" value="Back to Details"> </form>
                </li>
                <?php endif;?>
            </ul>
        </div>
    </nav>
    <br>
    <div class="headline">
        <h4>Update Information</h4></div>
    <div class="container">
        <div class="row">
            <div class="col-md-2"><b>Platform:</b>
                <?php echo $data->ProdLine;?>
            </div>
            <div class="col-md-4" id="SiteDisplay"><b>Site:</b>
                <?php echo $data->SiteKml;?> :
                    <?php echo $name;?>
            </div>
            <div class="col-md-2"><b>Update #:</b>
                <?php echo $data->UpdateNum;?>
            </div>
            <div class="col-md-2"><b>System:</b>
                <?php echo $data->System;?>
            </div>
            <div class="col-md-2"><b>Process:</b>
                <?php echo $data->Process;?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-3"><b>Task #:</b>
                <?php echo $data->Task;?>
            </div>
            <div class="col-md-2"><b>Update Release:</b>
                <?php echo $data->UpdateRelease;?>
            </div>
            <div class="col-md-2"><b>PPack:</b>
                <?php echo $data->UpdatePPack;?>
            </div>
        </div>
        <div class="row"><b>Update Note:</b>
            <div><?php echo nl2br($data->Note);?></div>
        </div>
             <div id="editInfo" class="editInfo pull-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#edit-modal">Edit</button>
            </div>
    </div>
    <div class="headline">
        <h4>Checklist</h4> </div>
        <div class="container">
            <div class="row">
                <div class="col-md-2"><b>Checklist ID: </b><?php echo $checklist->IDchecklist;?></div>
                <div class="col-md-2"><b>Version: </b><?php echo $checklist->Version;?></div>
                <div class="col-md-4"><b>Title: </b><?php echo $checklist->Title;?></div>
                <div class="col-md-2"><b>System: </b><?php echo $checklist->System;?></div>
                <div class="col-md-2"><b>Process: </b><?php echo $checklist->Process;?></div>
            </div>
            <div class="row"><b>Objective & Scope: </b><div><?php echo $checklist->Scope;?></div></div>
        </div>
            <div class="headline">
        <h4>Steps</h4> </div>
        <div class="row">
       <div id="loaderImage"> <img class="update-load" src="../js/ajax-loader.gif" alt=""> </div>
                <div id="pageContent">
                  </div>
        </div>
        <?php if(AdminComplete($id, $data->Status)):?>
                        <input type="submit" class="btn btn-danger" value="Admin Complete" onclick="adminComplete()">
<?php endif;?>
        <!-- Edit Update Info modal -->
            <div id="edit-modal" class="modal fade comment-modal">
                   <div class="modal-content">
                    <div class="modal-header"><h3>Edit Update Information</h3></div>
                    <form id="EditForm" action="#">
                    <div class="modal-body">
                         <div class="row">
                          <div class="col-md-5">
                    <label>Site</label>
                       <select onChange="checkRequired()" class="form-control" id="SiteKml" required>
                        <option value="">------</option>
                        <?php foreach($Site as $ddl): ?>
                            <option <?php if($ddl->SiteKml === $data->SiteKml){echo 'selected';} ?> value="<?php echo $ddl->SiteKml;?>">
                                <?php echo $ddl->SiteKml;?>: <?php echo $ddl->SiteName;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                    <div class="col-md-3">
                    <label>Update #</label>
                    <input required type="number" min="1" class="form-control" id="UpdateNum" max="9999" value="<?php echo $data->UpdateNum;?>" >
                    
                </div>
                       <div class="col-md-3">
                    <label>Task #</label>
                    <input required type="number" min="10000000" class="form-control" id="Task" max="99999999"  value="<?php echo $data->Task;?>">
                </div>
                        </div>
                         <div class="row">
                          <div class="col-md-3 col-md-offset-2">
                    <label>Update Release</label>
                       <select required class="form-control" id="Release">
                        <option value="">------</option>
                        <?php foreach($release as $ddl): ?>
                            <option <?php if($ddl->Rel === $data->UpdateRelease){echo 'selected';} ?>>
                                <?php echo $ddl->Rel;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                          <div class="col-md-3">
                    <label>PPack</label>
                       <select class="form-control" id="PPack" required>
                        <option value="">------</option>
                        <?php foreach($Ppack as $ddl): ?>
                            <option <?php if($ddl->PPack === $data->UpdatePPack){echo 'selected';} ?>>
                                <?php echo $ddl->PPack;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                            <label>Status</label>
                            <select class="form-control" id="Status" onChange="noteRequired()">
                            <?php foreach($status as $ddl): ?>
                            <option <?php if($ddl->Status === $data->Status){echo 'selected';} ?>>
                                <?php echo $ddl->Status;?>
                            </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        </div>
                        <div class="row col-md-offset-3">
                            <div class="col-md-3">
                                <label>Update Note</label>
                                <textarea id="Note" rows="5" cols="30"><?php echo $data->Note;?></textarea>
                            </div>
                        </div>
                        </div>
                    <div class="modal-footer">
                  
                    <input name="submit" class="btn btn-primary" type="submit" value="Save">
                     <input id="Cancel" class="btn btn-danger" type="button" data-dismiss="modal" value="Cancel">
                        </div>
                    </form>
                    </div>
                </div>
        
            
        <script src="../js/updatescript.js"></script>
        <script>
        $(document).ready(function(){
       checkRequired();
       if($process == 'Prerequisite'){ $('#Release').removeAttr("required"); $('#PPack').removeAttr("required"); $("#Task").removeAttr("required"); }
    
});

function checkRequired()
{
    
    let SiteKml = $('#SiteKml').val();
        if ((SiteKml === 'KML' || SiteKml === 'SHIP')){
            $("#UpdateNum").removeAttr("required");
            $("#Task").removeAttr("required");
        }else{
            $('#UpdateNum').prop('required',true);
            $("#Task").prop("required",true);
        }
        
}

function noteRequired()
{
 let status = $('#Status').val();
 if(status == 'On Hold' || status == 'Cancelled')
 {$("#Note").prop("required",true)}
 else {$("#Note").removeAttr("required");};
}
        </script>
       
        
