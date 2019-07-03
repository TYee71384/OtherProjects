<?php
$id=$_GET["Uid"];
$edit =$_GET["edit"];
require_once("../../Globals/init.php");
//get steps
$query = "SELECT * FROM LogUpdateSteps WHERE IDupdate= $id ORDER BY Step";
$steps = Query($query);
echo '<script> var $id='. json_encode($id) . '</script>';
function checkComplete($progress){
   switch($progress){
        case 'Done':
    echo 'checked';
    break;
        case 'Skip';
            echo 'disabled';
            break;
        default;
            break;
    }
   
}

function checkSkip($progress){
   switch($progress){
        case 'Skip':
    echo 'checked';
    break;
        case 'Done';
            echo 'disabled';
            break;
        default;
            break;
    }

    
}


?>
<script>

if($status === 'Complete'){$('.admin-check').addClass('blue')}</script>
    <div class="container">
       <?php if($edit!="true"):?>
        <?php foreach($steps as $step):?>
            <div class="well">
                <div class="row">
                    <div class="col-md-2 padding">
                        <?php if($step->Progress=="Done"):?> <span class="glyphicon glyphicon-ok"></span>
                            <?php elseif($step->Progress=="Skip"):?> <span class="glyphicon glyphicon-remove"></span>
                                <?php else:?> <span class="glyphicon glyphicon-question-sign admin-check"></span>
                                    <?php endif;?>
                    <div class="col-md-2 pull-right">
                         <h4><?php echo $step->Step;?></h4>
                    </div>
                    </div>
                    <div class="col-md-7">
                        <?php echo $step->StepText;?>
                        
                        <?php if($step->Comment):?>
                        <br>
                        <b>Comment:</b> <?php echo $step->Comment;?>
<?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php else:?>
            <?php foreach($steps as $step):?>
               <div class="well">
                <div class="row">
                        <div class="col-md-1">
             <input id="complete-<?php echo $step->Step;?>" type="checkbox" class="form-control" <?php checkComplete($step->Progress);?> onclick="Complete(<?php echo $step->Step;?>)">
        </div>
                        <div class="col-md-2">
                            <h4><?php echo $step->Step;?></h4>
                        </div>
                    <div class="col-md-7">
                        <?php echo $step->StepText;?>
                    </div>
                </div>
                <div class="row container">
            
            <div class="col-md-2 no-margin">
            <label>Comment:</label>
            </div>
            <div class="col-md-6">
            <input class="form-control no-margin" id="comment-<?php echo $step->Step;?>" onchange="SaveComment(<?php echo $step->Step;?>)" type="text" value="<?php echo $step->Comment;?>">
            </div>
            <div class="col-md-2 col-md-offset-2 no-margin">
                <label>Skip Step <?php echo $step->Step;?>:</label>
            </div>
                <div class="col-md-1">
                <input id="skip-<?php echo $step->Step;?>" class="form-control" type="checkbox" <?php checkSkip($step->Progress);?> onclick="Skip(<?php echo $step->Step;?>)">
                </div>
            </div>
            <div id="comment-modal<?php echo $step->Step;?>" class="modal fade comment-modal">
               <div class="modal-content">
                <div class="modal-header"><h3>Comment for Step <?php echo $step->Step;?></h3></div>
                <form id="commentForm">
                <div class="modal-body">
                    <input id="stepComment" type="text" name="Comment" class="form-control" value="<?php echo $step->Comment;?>" required>
                </div>
                <div class="modal-footer">
                 <input type="hidden" name="Step" value="<?php echo $step->Step;?>">
                  <input type="hidden" name="IDupdate" value="<?php echo $step->IDupdate;?>">
                <input type="submit" class="btn btn-primary" id="save-comment" value="Save">
                    <a class="btn btn-danger" id="cancel-comment" onclick="CancelComment(<?php echo $step->Step;?>)">Cancel</a>
                    </div>
                </form>
                </div>
            </div>
            </div>
           
                
    
            <?php endforeach;?>
            <?php endif;?>
</div>


