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
                <h3><?php echo $data->ProdLine;?> <?php echo $data->SiteKml;?> : Update # <?php echo $data->UpdateNum;?> : <?php echo $data->Process;?></h3> </div>
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
            <div class="col-md-4"><b>Site:</b>
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
                    <form action="#">
                    <input type="text" required>
                    <button class="btn-btn-default">Submit</button>
                    </form>
                    </div>
                </div>
        
                <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script></script>
        <script src="../js/updatescript.js"></script>
       
        
