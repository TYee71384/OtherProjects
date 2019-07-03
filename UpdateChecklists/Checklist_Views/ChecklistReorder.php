<?php
require_once('header.php');
require_once('../Checklist_Processes/Editor_Details.php');

?>
   <?php if($data->Status !="Draft"){
header("Location: ../Checklist_Views/ChecklistDetails.php?cid=$id&ver=$version");
exit();
}
?>
   
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
           
            <h3>Checklist ID: <?php echo $id?> Version: <?php echo $version; ?></h3> </div>
             <div class="status" style="color:<?php echo color($data->Status);?>;">
                <h3><?php echo $data->Status;?></h3> </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <form action="ChecklistEditor.php" class="navbar-form" method="post">
                    <input type="hidden" name="cid" value="<?php echo $id;?>">
                    <input type="hidden" name="ver" value="<?php echo $version;?>">
                    <input type="hidden" name="status" value="<?php echo $data->Status;?>">
                    <input type="submit" class="btn btn-default" name="Editsubmit" value="Back to Editor"> </form>
            </li>
        </ul>
        </div>
    </nav>
    <div class="container">
        <div class="headline">
            <h4>Steps</h4></div>
        <div id="steps" class="col-md-12">
            <?php foreach($steps as $step): ?>
                  <div class="well" id="step-<?php echo $step->IDstep;?>">
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
        <script>
            $('#steps').sortable({
                update: function (event, ui) {
                    var data = $(this).sortable('serialize');
                    data = data;
                    $.ajax({
                        data: data
                        , type: 'POST'
                        , url: '../Checklist_Processes/Reorder.php'
                        , success: (function () {
                            location.reload();
                             
                        })
                    });
                }
            });
        </script>