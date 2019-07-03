$(document).ready(()=>{
    $status = encodeURIComponent($status);
    var isFirefox = typeof InstallTrigger !== 'undefined';
    if(isFirefox) {alert('Please Use Chrome, Firefox might be unstable when saving data');
    
    location.replace('index.php')}
    
        window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
            alert("Back button is disabled. Please close window if trying to leave this page");
        };

    $('#loaderImage').show();
    showContent();
    showProgress(); 
  
function closeWindow(){
    window.open('','_parent',''); 
  window.close(); 
}

    //console.log(data);

    //comment model (when clicking skip)
        $(document).on('submit','#commentForm',function(){
        $('.comment-modal').modal('hide');
            $('body').removeClass('modal-open');
          //  console.log($(this).serialize()+'Status='+$status)
        $.post("../update_processes/SkipStep.php",$(this).serialize()+'&Status='+$status)
            .done(function(data){
            
             toastr.options.timeOut=1000;
               toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            
           
            //showContent();
           // showProgress();
            GetPercentage();
            location.reload();
            toastr.success('Comment Saved');
        }).fail(function(data){
             toastr.options.timeOut=2000;
            toastr.error('Could not save. Please try again');
        });
        return false;
    });
    

});

function showContent(){
    if($edit=="true")
        {
            $('#editInfo').show();
            
        }
    
    setTimeout("$('#pageContent').load('steps.php?Uid='+$id+'&edit='+$edit+'&status='+$status,()=>{$('#loaderImage').hide();})",500);
}

function showProgress(){
      
    setTimeout("$('#ProgressBar').load('progress.php?Uid='+$id)",250);
    
    //$('#ProgressBar').load('progress.php?Uid='+$id);
      
   
}

function adminComplete(){
    var complete = confirm("Are you sure you want to complete this checklsit?");
    if(complete == true)
    {
        
    $.post("../update_processes/adminComplete.php?UID="+$id).done(()=> window.location.href = '../update_views/updatedetails.php?UID='+$id);
   // Completed();
    }

}

function GetPercentage(){
     setTimeout("$.get('../update_processes/getpercentage.php?Uid='+$id,function(data){isComplete(data);})",250)
}

function isComplete(data){
    if(data == '"100%"'){
        $.post("../update_processes/markascomplete.php?UID="+$id).done(()=>window.location.href = '../update_views/updatedetails.php?UID='+$id);
       // Completed();
    }
}

function Completed(){
    alert('Checklist is now complete. No changes can be made');
   
    
}

function Skip($step){
    var $skip = '#skip-'+$step;
     var $comment ='#comment-'+$step;
    var $complete ='#complete-'+$step;
    if($($skip).is(':checked')){
            $($complete).attr('disabled',true);
            $($comment).attr('required',true);
            //$($comment).focus();
            
        if($($comment).val() =='')
            {
                $($comment).focus();
                $('#comment-modal'+$step).modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        else{
            $.post("../update_processes/SkipStep.php", {Step:$step,Comment:$($comment).val(),IDupdate:$id,Status:$status}).done(GetPercentage).done(showProgress)
        }
            
        }
    else{
         $($complete).attr('disabled',false);
        $($comment).attr('required',false);
        $.post("../update_processes/ClearStatus.php", {Step:$step,Comment:$($comment).val(),IDupdate:$id,Status:$status}).done(showProgress)
    }
    
}

function Complete($step)
{
    var $skip = '#skip-'+$step;
     var $comment ='#comment-'+$step;
    var $complete ='#complete-'+$step;
   
        if($($complete).is(':checked')){
            $($skip).attr('disabled',true);
            $.post("../update_processes/CompleteStep.php", {Step:$step,Comment:$($comment).val(),IDupdate:$id,Status:$status}).done(GetPercentage).done(showProgress)
        }
    else{
         $($skip).attr('disabled',false);
        $.post("../update_processes/ClearStatus.php", {Step:$step,Comment:$($comment).val(),IDupdate:$id,Status:$status}).done(showProgress)
        
        
    }
}

function SaveComment($step){

    $newComment = $('#comment-'+$step).val();
    var $skip = '#skip-'+$step;
    if($newComment === '' && $($skip)[0].checked){
        $($skip).attr('checked',false);
        $.post("../update_processes/ClearStatus.php", {Step:$step,Comment:$newComment,IDupdate:$id,Status:$status}).done(showProgress());
    }
    $.post("../update_processes/SaveComment.php", {Step:$step,Comment:$newComment,IDupdate:$id}).done();
}

function CancelComment($step)
{
    var $comment ='#comment-modal'+$step;
    var $skip = '#skip-'+$step;
    var $complete ='#complete-'+$step;
    $($comment).modal('toggle');
    $('#stepComment').val('');
    $($skip).attr('checked',false);
    $($complete).attr('disabled',false);
}
    
 $(document).on('submit','#EditForm',function(){
     let PPack = $('#PPack').val();
     let Task = String($('#Task').val());
     let SiteKml = $('#SiteKml').val();
     let UpdateNum = $('#UpdateNum').val();
     let Release = $('#Release').val();
     let Note = $('#Note').val();
     let Status = $('#Status').val();
     let path = '';

//	 AND IDchecklist=" & intIDchecklist & " AND IDupdate<>" & intIDupdate & " AND Status<>'Cancelled'" 

    // console.log('Status :' + Status);
        $('#edit-modal').modal('hide');
            $('body').removeClass('modal-open');
            if ((SiteKml === 'KML' || SiteKml === 'SHIP') || ($sys == 'Test' && $process == 'Deletion')){
                
                path = "../Update_Processes/Save_UpdateInfo_KML.php";
            }else{
 path = "../Update_Processes/Save_UpdateInfo.php";
            }
            
        $.post(path,{PPack:PPack,Task:Task,SiteKml:SiteKml,UpdateNum:UpdateNum,Release:Release,Note:Note,Status: Status,UID:$id, ProdLine: $prodLine, CID: $checklistId})
            .done(function(data){
            
            $('.modal-backdrop').remove();
             toastr.options.timeOut=1000;
               toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.success('Update Information Saved');
           location.reload();
           // location.reload();
        }).fail(function(data){
             toastr.options.timeOut=2000;
            toastr.error('Could not save. Please try again');
        });
        return false;
    });




    



