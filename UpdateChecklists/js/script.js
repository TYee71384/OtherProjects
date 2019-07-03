$(document).ready(()=>{
    $('#loaderImage').show();
    showContent();
    
    $(document).on('submit','#EditForm',function(){
        $('.EditModal').modal('hide');
            $('body').removeClass('modal-open');
        $.post("../Checklist_Processes/ChecklistEditor_Process.php",$(this).serialize())
            .done(function(data){
            $('.modal-backdrop').remove();
             toastr.options.timeOut=1000;
               toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.success('Step Saved');
            showContent();
           // location.reload();
        }).fail(function(data){
             toastr.options.timeOut=2000;
            toastr.error('Could not save. Please try again');
        });
        return false;
    });
    
    $(document).on('submit','#EditDescription',function(){

          $('#EditDesc').modal('hide');
             $('body').removeClass('modal-open');
        $.post("../Checklist_Processes/ChecklistEditor_Process2.php",$(this).serialize())
            .done(function(data){
            $('.modal-backdrop').remove();
             toastr.options.timeOut=1000;
             toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.success('Description Saved');
            showContent();
           // location.reload();
        }).fail(function(data){
             toastr.options.timeOut=2000;
            toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.error('Could not save. Please try again');
        });
       
        return false;
    });
    
    	$(document).on('submit','#delete', function(){
		
		//Post data from form
        var del =  confirm("Are you sure you want to delete this step?");
            if(del==true){
		$.post("../Checklist_processes/Step_Delete.php?cid="+$id+'&ver='+$version, $(this).serialize())
			.done(function(data){
            toastr.options.timeOut=1000;
               toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.warning('Step Deleted');
            showContent();
           
			}).fail(function(data){
             toastr.options.timeOut=2000;
               toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.error('Could not delete. Please try again');
        });
       }
			return false;
	});           
    
});

function showContent(){
    setTimeout("$('#pageContent').load('steps.php?cid='+$id+'&ver='+$version,()=>{$('#loaderImage').hide();$('.add-btn').show()})",500);
    //$('#pageContent').load('steps.php?cid='+$id+'&ver='+$version);
}

tinymce.init({
    //selector: 'textarea',
	//selector: 'textarea#id',
	//selector: 'textarea.class',
	selector: 'textarea.TinyMCE',
	width: 1100,
    height: 300,
    theme: 'modern',
    plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern'],
    toolbar: 'undo redo | removeformat | formatselect | fontsizeselect | bold italic underline | forecolor | alignleft aligncenter alignright | bullist numlist | table | outdent indent | link unlink image | preview',
    menubar: false,
  	//statusbar : false,
	resize: 'both',
	image_advtab: false,
	table_advtab: false,
	table_row_advtab: false,
	table_cell_advtab: false,
	//paste_as_text: true,
	custom_undo_redo_levels: 10
});

    $(document).on('click','#submit', ()=>{
		let text= tinymce.get('content').getContent();
        console.log(text);
		//Post data from form
		$.post("../Checklist_Processes/AddStep.php", {text: text, id: $id, ver: $version})
			.done(function(data){
            tinyMCE.activeEditor.setContent('');
              toastr.options.timeOut=1000;
               toastr.options = {
                "positionClass": "toast-bottom-right",
            }
            toastr.success('New Step added');
				showContent();
			}).fail(function(data){
               toastr.options = {
                "positionClass": "toast-bottom-right",
            }
             toastr.options.timeOut=2000;
            toastr.error('Could not add new step. Please try again');
        });
			return false;
    });
    
  function clear(){
      console.log('here');
   // tinyMCE.activeEditor.setContent('');
  }
    
    


    



