<?php require_once('header.php');
require_once('../Update_Processes/checklistselect_load.php');

?>

 <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3><?php echo $title;?></h3> </div>
        </div>
    </nav>

 <?php if (!empty($data[0])) {
             ?>
      <center><span class="Text"><font size=4>Continue with an existing checklist:</font></span></center>
      <br>
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
                    <?php foreach($data[0] as $match) : ?>
                        <tr class=<?php echo str_replace(' ', '',$match->Status);?>>
                            <td>
                                <?php echo $match->ProdLine;?>
                            </td>
                            <td>
                                <?php echo $match->SiteKml;?>
                            </td>
                            <td>
                                <?php echo $match->UpdateNum;?>
                            </td>
                            <td>
                                <?php echo $match->System;?>
                            </td>
                            <td>
                                <?php echo $match->Process;?>
                            </td>
                            <td>
                                <?php echo $match->Task;?>
                            </td>
                            <td>
                                <?php echo $match->UpdateRelease;?>
                            </td>
                            <td>
                                <?php echo $match->UpdatePPack;?>
                            </td>
                              <td>
                                <?php echo $match->IDchecklist;?>
                            </td>
                            <td>
                                <?php echo $match->Version;?>
                            </td>
                              <td>
                                <?php if($match->StartTime !=null):?>
                               <?php echo date('m/d/Y', strtotime($match->StartTime));?>
                               <?php endif;?>
                            </td>
                            <td>             
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
                                <?php if($match->Status == "In Progress" || $match->Status == "On Hold"): ?>
                                  <a href="UpdateDetails.php?UID=<?php echo $match->IDupdate;?>&edit=true"><?php echo $match->Status ." ". GetPercentage($match->IDupdate);?></a>
                                  <?php else:?>
                                 <a href="UpdateDetails.php?UID=<?php echo $match->IDupdate;?>"><?php echo $match->Status;?></a>
                                  <?php endif;?>          
                            </td>
                           
                        </tr>
                        <?php endforeach;?>
                </tbody>
            </table>
            <h3 class="text-center">Records found: <?php echo $data[1];?></h3>
            <?php } elseif(!$error & $result) { ?>
                <center><span class="Text"><font size=4>Start a new checklist from the following suggested checklists:</font></span></center>
                <br>
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
                         <th>Action</th>
                     </tr>
                 </thead>
                 <tbody class="highlight">
                     <?php foreach($result as $match) : ?>
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
                             <td>
                             <?php $url = "UpdateStarter.php?CID=" . $match->IDchecklist.'&Ver='.$match->Version . '&Site=' . $_GET['Site'] . '&Upd=' . $_GET['Upd'];
                                    if($task) $url .= '&Task='.$task;
                                    if($rel) $url .= '&Rel='.$rel;
                                    if($ppack) $url .= '&PP='.$ppack;
                             ?>
                             <a href="<?php echo $url?>"
                             
                             >Start</a>
                             </td>
                         </tr>
                         <?php endforeach;?>
                 </tbody>
             </table>
             <?php
            }else{
                 
        echo '<div class="row"><div class="container col-md-12"><h3 class="text-center">No Results Found</h3></div></div>';
    }  ?>