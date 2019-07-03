<?php
require_once('../../Globals/init.php');
require_once('../Checklist_Processes/Editor_Details.php');
$platform = Query("Select ProdLine from ListProdLine");
$system = Query("Select System from ListSystem ORDER BY SortOrder");
$process = Query("Select Process from ListProcess ORDER BY SortOrder");
$release = Query("Select Rel from ListRelease");
$type = Query("Select Type from ListType ORDER BY SortOrder");
?>
  <div class="row">
   <div class="headline">
            <h4>Description</h4></div>
</div>
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
        <!--    <table>
                <tr class="SectionText">
                    <td width=50 nowrap>&nbsp;</td>
                    <td align="left">Platform:</td>
                    <td width=10 nowrap>&nbsp;</td>
                    <td align="left">System:</td>
                    <td width=10 nowrap>&nbsp;</td>
                    <td align="left">Process:</td>
                    <td width=10 nowrap>&nbsp;</td>
                    <td align="left">Release:</td>
                    <td width=10 nowrap>&nbsp;</td>
                    <td align="left">Type:</td>
                    <td width=50 nowrap>&nbsp;</td>
                </tr>
                <tr class="SectionData">
                    <td width=50 nowrap>&nbsp;</td>
                    <td align="left">
                        <?php echo $data->ProdLine; ?>
                    </td>
                    <td width=10 nowrap>&nbsp;</td>
                    <td align="left">
                        <?php echo $data->System; ?>
                    </td>
                    <td width=10 nowrap>&nbsp;</td>
                    <td align="left">
                        <?php echo $data->Process;?>
                    </td>
                    <td width=10 nowrap>&nbsp;</td>
                    <td align="left">
                        <?php echo $data->Rel;?>
                    </td>
                    <td width=10 nowrap>&nbsp;</td>
                    <td align="left">
                        <?php echo $data->Type;?>
                    </td>
                    <td width=50 nowrap>&nbsp;</td>
                </tr>
            </table>
        </div>-->
        </div>
        <div class="row col-md-12">
          <b>Objective & Scope: </b>
        <div><?php echo nl2br($data->Scope);?></div>
            </div>
            <br>
            <button data-toggle="modal" class="btn btn-primary btn-Edit pull-right" data-target="#EditDesc">Edit</button>
            <!--Description Model -->
            <div id="EditDesc" data-toggle="modal" class="modal fade">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Edit Description</h3> </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="EditDescription">
                            <label>Title</label>
                            <input type="text" name="Title" class="form-control" value="<?php echo $data->Title;?>" required>
                            <div class="row">
                                <div class="col-md-offset-1">
                                    <div class="col-md-2 form-group">
                                        <label>Platform</label>
                                        <select class="form-control" name="Platform" required>
                                            <option value="">------</option>
                                            <?php foreach($platform as $ddl): ?>
                                                <option value="<?php echo $ddl->ProdLine;?>" <?php if($ddl->ProdLine==$data->ProdLine) {echo 'selected';}?>>
                                                    <?php echo $ddl->ProdLine;?>
                                                </option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>System</label>
                                        <select class="form-control" name="System" required>
                                            <option value="">------</option>
                                            <?php foreach($system as $ddl): ?>
                                                <option value="<?php echo $ddl->System;?>" <?php if($ddl->System==$data->System) {echo 'selected';}?>>
                                                    <?php echo $ddl->System;?>
                                                </option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Process</label>
                                        <select class="form-control" name="Process" required>
                                            <option value="">------</option>
                                            <?php foreach($process as $ddl): ?>
                                                <option value="<?php echo $ddl->Process;?>" <?php if($ddl->Process==$data->Process) {echo 'selected';}?>>
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
                                                <option value="<?php echo $ddl->Rel;?>" <?php if($ddl->Rel==$data->Rel) {echo 'selected';}?>>
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
                                                <option value="<?php echo $ddl->Type;?>" <?php if($ddl->Type==$data->Type) {echo 'selected';}?>>
                                                    <?php echo $ddl->Type;?>
                                                </option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-offset-3 col-md-6">
                                    <label>Objective & Scope</label>
                                    <textarea required rows="5" type="text" name="Scope" class="form-control"><?php echo $data->Scope;?></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-md-6 col-md-offset-6">
                                    <input class="btn btn-primary" name="submit" type="submit" value="Save">
                                    <input type="hidden" name="cid" value="<?php echo $id;?>">
                                    <input type="hidden" name="ver" value="<?php echo $version;?>">
                                    <input id="Cancel" class="btn btn-danger" type="button" data-dismiss="modal" value="Cancel"> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</div>
           <div class="row">
            <div class="headline">
                <h4>Steps</h4></div>
</div>
            <div class="container">
                    <?php foreach($steps as $step): ?>
                           <div class="well">
                               <div class="row">
                                   <div class="col-md-2 padding">
                                       <h3><?php echo $step->Step;?></h3>
                                   </div>
                                   <div class="col-md-7">
                                        <?php echo $step->StepText;?>
                                   </div>
                               </div>
                          <div class="row">
                               <div class="col-md-2 padding">
                                        <div id="EditStep-<?php echo $step->IDstep;?>" class="modal fade EditModal">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2>Edit Step <?php echo $step->Step;?></h2> </div>
                                                <div class="modal-body">
                                                    <form action="#" method="post" id="EditForm">
                                                        <textarea name="step" class="edit" cols="30" rows="10">
                                                            <?php echo $step->StepText;?>
                                                        </textarea>
                                                        <input type="hidden" name="StepID" value="<?php echo $step->IDstep;?>">
                                                        <input type="hidden" name="cid" value="<?php echo $id;?>">
                                                        <input type="hidden" name="ver" value="<?php echo $version;?>">
                                                        <div class="modal-footer">
                                                            <input class="btn btn-primary" name="submit" type="submit" value="Save">
                                                            <input id="Cancel" class="btn btn-danger" type="button" data-dismiss="modal" value="Cancel"> </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                              </div>
                                         <div class="col-md-2 pull-right">
                                         <div class="col-md-6">
                                         <button data-toggle="modal" class="btn btn-primary btn-Edit" data-target="#EditStep-<?php echo $step->IDstep;?>">Edit</button>
                                         </div>
                                          <form id="delete" action="#" method="post">
                                                <input type="hidden" name="StepID" value="<?php echo $step->IDstep;?>">
                                                <input type="hidden" name="cid" value="<?php echo $id;?>">
                                                <input type="hidden" name="ver" value="<?php echo $version;?>">
                                                <input type="submit" class="btn btn-danger delete-btn" value="Delete"> </form>
                                   </div>
                           
                               </div>
                </div>
                            <?php endforeach;?>
                        </div>
               
            
    <script>
        tinymce.init({
            //selector: 'textarea',
            //selector: 'textarea#id',
            //selector: 'textarea.class',
            selector: 'textarea.edit'
            , width: 1100
            , height: 300
            , theme: 'modern'
            , plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern']
            , toolbar: 'undo redo | removeformat | formatselect | fontsizeselect | bold italic underline | forecolor | alignleft aligncenter alignright | bullist numlist | table | outdent indent | link unlink image | preview'
            , menubar: false, //statusbar : false,
            resize: 'both'
            , image_advtab: false
            , table_advtab: false
            , table_row_advtab: false
            , table_cell_advtab: false, //paste_as_text: true,
            custom_undo_redo_levels: 10
        });
    </script>