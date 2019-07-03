<?php
$id=$_GET["CID"];
$version = $_GET["Ver"];
require_once('header.php');

//Get Checklist Info
$query = "SELECT * FROM LogChecklist WHERE IDchecklist = $id AND Version = $version";
$checklist = Query($query,1);

//dropdown info
$release = Query("Select Rel from ListRelease");
$Site = Query("SELECT ProdLine,SiteKml,SiteName FROM ListSite WHERE ProdLine = '$checklist->ProdLine' ORDER BY ProdLine,SiteKml");
$Ppack = Query("Select PPack from ListPPack");


$checklistID ='';
$version ='';
$platform_value ='';
$release_value ='';
$system_value ='';
$process_value ='';
$site_value ='';
$ppack_value='';                              
$task = '';
$status_value='';
$updateNum = '';
$upd_num = '';

if(!empty($_GET["Task"])){
$task = $_GET['Task'];
}
if(!empty($_GET["Rel"])){
    $release_value = $_GET['Rel'];
    }
if(!empty($_GET["Sys"])){
   $system_value = $_GET['Sys'];
   }
if(!empty($_GET["Proc"])){
    $process_value = $_GET['Proc'];
    }
if(!empty($_GET["PP"])){
    $ppack_value = $_GET['PP'];
        }
if(!empty($_GET["Site"])){
     $site_value = $_GET['Site'];
                }
if(!empty($_GET["Upd"])){
   $upd_num = $_GET['Upd'];
                        }
    


?>
 <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3>Update Starter</h3> </div>
        </div>
    </nav>

 <div class="headline">
        <h4>Update Information</h4></div>
<form method="post" action="" id="Starter">
           <div class="container">
        <div class="row">
            <div class="col-md-1"><b>Platform:</b>
                <?php echo $checklist->ProdLine;?>
            </div>
             <div class="col-md-5">
                    <label>Site</label>
                       <select class="form-control" name="SiteKml" id="SiteKml" onChange="checkRequired()" required>
                        <option value="">------</option>
                        <?php foreach($Site as $ddl): ?>
                            <option value="<?php echo $ddl->SiteKml;?>" <?php if($ddl->SiteKml === $site_value){echo 'selected';}?>>
                                <?php echo $ddl->SiteKml;?>: <?php echo $ddl->SiteName;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
            <div class="col-md-2">
                    <label>Update #</label>
                    <input type="number" min="1" max="9999" class="form-control" <?php if($upd_num){echo 'value='.$upd_num;} ?>  id="updatenum" name="UpdateNum" required>
                </div>
            <div class="col-md-1"><b>System:</b>
                <?php echo $checklist->System;?>
            </div>
            <div class="col-md-1"><b>Process:</b>
                <?php echo $checklist->Process;?>
            </div>
        </div>
                         <div class="row">
                            <div class="col-md-2 col-md-offset-2">
                    <label>Task #</label>
                    <input type="number" min="10000000" class="form-control" id="Task" name="Task" max="99999999" <?php if($task){echo 'value='.$task;}?> required>
                </div>
                          <div class="col-md-2">
                    <label>Update Release</label>
                       <select class="form-control" name="Release" id="Release" required>
                        <option value="">------</option>
                        <?php foreach($release as $ddl): ?>
                            <option <?php if($ddl->Rel === $release_value){echo 'selected';} ?>>
                                <?php echo $ddl->Rel;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                          <div class="col-md-2">
                    <label>PPack</label>
                       <select class="form-control" name="PPack" id="PPack" required>
                        <option value="">------</option>
                        <?php foreach($Ppack as $ddl): ?>
                            <option <?php if($ddl->PPack === $ppack_value){echo 'selected';} ?>>
                                <?php echo $ddl->PPack;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
    </div>
</div>
    <div class="headline">
        <h4>Checklist</h4> </div>
        <div class="container">
            <div class="row col-md-offset-2">
                <div class="col-md-2"><b>Checklist ID: </b><?php echo $checklist->IDchecklist;?></div>
                <div class="col-md-2"><b>Version: </b><?php echo $checklist->Version;?></div>
                 <div class="col-md-2"><b>Status: </b><?php echo $checklist->Status;?></div>
                <div class="col-md-4"><b>Title: </b><?php echo $checklist->Title;?></div>
            </div>
                <div class="row col-md-offset-2">
                    <div class="col-md-2"><b>Platform: </b><?php echo $checklist->ProdLine;?></div>
                    <div class="col-md-2"><b>System: </b><?php echo $checklist->System;?></div>
                <div class="col-md-2"><b>Process: </b><?php echo $checklist->Process;?></div>
                 <div class="col-md-2"><b>Release: </b><?php echo $checklist->Rel;?></div>
                    <div class="col-md-2"><b>Type: </b><?php echo $checklist->Type;?></div>
            </div>
            <div class="row"><b>Objective & Scope: </b><div><?php echo nl2br($checklist->Scope);?></div>
        </div><br></div>
        <div class="headline"></div>
        <div class="row col-md-offset-5">
        <input type="hidden" name="CID" value="<?php echo $id;?>">
        <input type="hidden" name="Ver" value="<?php echo $checklist->Version;?>">
        <input type="hidden" name="ProdLine" value="<?php echo $checklist->ProdLine;?>">
        <input type="hidden" name="System" value="<?php echo $checklist->System;?>">
        <input type="hidden" name="Process" value="<?php echo $checklist->Process;?>">
        <input type="submit" name="start" class="btn btn-primary" value="Start Update">
        </div>
        </form>
    <script>
   
   
           $(document).ready(function(){
            
       checkRequired();
      // $("#Task").removeAttr("required");
    
});

function checkRequired()
{
    
    let SiteKml = $('#SiteKml').val();
    let $proc = "<?php echo $checklist->Process;?>";

    if($proc == 'Prerequisite'){ $('#Release').removeAttr("required"); $('#PPack').removeAttr("required"); $("#Task").removeAttr("required"); }
        if ((SiteKml.startsWith('KML') || SiteKml.startsWith('SHIP'))){
            $("#updatenum").removeAttr("required");
            $("#Task").removeAttr("required");
        }else{
            $('#updatenum').prop('required',true);
            if($proc !== 'Prerequisite')
            $("#Task").prop("required",true);
            
        }
 if($proc == 'Notification') {
    $("#Task").prop("required",false);
 }      
}
    </script>
<script>
$('#Starter').on('submit',function(){
    $.post('../update_processes/updatestarter_process.php',$(this).serialize()).done(
    function(data){
        try{
        var siteInfo = $.parseJSON(data); if(siteInfo.message){toastr.options.timeOut=5000;
        toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.error(siteInfo.message);}
            else{
                toastr.success(siteInfo.done);
                window.location.href = "updatedetails.php?UID="+siteInfo.done+"&edit=true";
            }
    }
    
        catch(e){}
    }
    );
     return false;
});

</script>