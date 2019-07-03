<?php
require_once('header.php');
require_once('../Checklist_Processes/ChecklistDetails_Load.php');

?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3>Checklist ID: <?php echo $id?> Version: <?php echo $version; ?></h3> </div>
            <div class="status" style="color:<?php echo color($data->Status);?>;">
                <h3><?php echo $data->Status;?></h3> </div>
            <ul class="nav navbar-nav navbar-right">
                <li> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><b class="caret"></b></a>
                    <div class="dropdown-menu"> <b>Last Activity: </b>
                        <?php echo $history->FileTime;?>
                            <div class=""> <b>Last User: </b>
                                <?php echo $history->FileBy;?>
                            </div>
                    </div>
                </li>
                <li class="history-link">
                    <form method="post" class="navbar-form" action="ChecklistHistory.php?cid=<?php echo $id.'&ver='.$version;?>">
                        <input type="submit" class="btn btn-default" value="View History"> </form>
                </li>
                <?php if($allowEdit =="Y"):?>
                    <li>
                        <form action="ChecklistEditor.php" class="navbar-form" method="post">
                            <input type="hidden" name="cid" value="<?php echo $id;?>">
                            <input type="hidden" name="ver" value="<?php echo $version;?>">
                            <input type="hidden" name="status" value="<?php echo $data->Status;?>">
                            <input type="submit" class="btn btn-default" name="Editsubmit" value="Edit"> </form>
                    </li>
                    <?php endif;?>
                        <?php if($allowApprove =="Y"):?>
                            <li>
                                <form action="../Checklist_Processes/ChecklistApprove.php" class="navbar-form" method="post">
                                    <input type="hidden" name="cid" value="<?php echo $id;?>">
                                    <input type="hidden" name="ver" value="<?php echo $version;?>">
                                    <input type="submit" class="btn btn-default" name="Approvesubmit" value="Approve"> </form>
                            </li>
                            <?php endif;?>
                                <?php if($allowDraft =="Y"):?>
                                    <li>
                                        <form action="../Checklist_Processes/ChecklistDraft.php" class="navbar-form" method="post">
                                            <input type="hidden" name="cid" value="<?php echo $id;?>">
                                            <input type="hidden" name="ver" value="<?php echo $version;?>">
                                            <input type="hidden" name="status" value="<?php echo $data->Status;?>">
                                            <input type="submit" class="btn btn-default" name="Draftsubmit" value="Create New Version"> </form>
                                    </li>
                                    <?php endif;?>
                                        <?php if($allowStarter =="Y"):?>
                                            <li>
                                                <form action="../Update_Views/UpdateStarter.php?CID=<?php echo $id;?>&Ver=<?php echo $version;?>" class="navbar-form" method="post">
                                                    <input type="submit" class="btn btn-default" name="submit" value="Update Starter"> </form>
                                            </li>
                                            <?php endif;?>
                                                <li>
                                                    <form class="navbar-form"> <a href="ChecklistSearch.php" class="btn btn-default">Back to Search</a> </form>
                                                </li>
            </ul>
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div class="container checklist-body">
    <br>
        <?php if($scope_error!=null):?>
            <div class="text-center scope">
                <h4> <?php {echo $scope_error;}?></h4></div>
            <?php endif?>
                <div class="headline">
                    <h4>Description</h4></div>
                  <div class="container">
        <div class="col-md-12 row">
            <div class="text-center"> <b>Title: </b>
                <?php echo $data->Title;?>
            </div>
        </div>
        <div class="row col-md-offset-1">
        <div class="col-md-2">
            <b>Platform: </b><?php echo $data->ProdLine;?>
        </div>
        <div class="col-md-2">
            <b>System: </b><?php echo $data->System;?>
        </div>
        <div class="col-md-2">
            <b>Process: </b><?php echo $data->Process;?>
        </div>
        <div class="col-md-2">
            <b>Release: </b><?php echo $data->Rel;?>
        </div>
        <div class="col-md-2">
            <b>Type: </b><?php echo $data->Type;?>
        </div>
        </div>
        <div class="row col-md-12">
          <b>Objective & Scope: </b>
        <div><?php echo nl2br($data->Scope);?></div>
            </div>
        </div>
                    <div class="headline step-headline">
                        <h4>Steps</h4></div>
                    <div class="container">
                        <?php foreach($steps as $step):?>
                            <div class="well">
                               <div class="row">
                                <div class="col-md-2 padding">
                                    <h3><?php echo $step->Step;?></h3> </div>
                                <div class="col-md-7">
                                    <?php echo $step->StepText;?>
                                </div>
                            </div>
                        </div>
                            <?php endforeach;?>
                    </div>
                    <br>
                    <?php if($data->Status !="Draft"):?> <b class="gray">Page Identification Information</b>
                        <table class="table-bordered pid-width page-id">
                            <tr>
                                <td><b>Document Status</b></td>
                                <td>
                                    <?php echo $history->Status;?>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Version #</b></td>
                                <td>
                                    <?php echo $history->Version;?>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Effetive Date</b></td>
                                <td>
                                    <?php echo date("m/d/Y H:i:s",strtotime($history->FileTime));?>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Approved By</b></td>
                                <td>
                                    <?php echo $history->FileBy;?>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Approved Date</b></td>
                                <td>
                                    <?php echo date("m/d/Y H:i:s",strtotime($history->FileTime));?>
                                </td>
                            </tr>
                        </table>
                        <?php endif;?>
                        <br>
                            <?php if($allowArchive=="Y"):?>
                                <form action="../Checklist_Processes/ChecklistArchive.php" method="post">
                                    <input class="btn btn-info" type="submit" value="Mark as Archived">
                                    <input type="hidden" name="cid" value=<?php echo $id;?>>
                                    <input type="hidden" name="ver" value=<?php echo $version?>> </form>
                                <?php endif;?>
                                    <?php if($allowDelete=="Y"):?>
                                        <form action="../Checklist_Processes/ChecklistDelete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this checklist?');">
                                            <input class="btn btn-danger" type="submit" value="Delete Draft Checklist">
                                            <input type="hidden" name="cid" value=<?php echo $id;?>>
                                            <input type="hidden" name="ver" value=<?php echo $version?>> </form>
                                        <?php endif;?>
    </div>