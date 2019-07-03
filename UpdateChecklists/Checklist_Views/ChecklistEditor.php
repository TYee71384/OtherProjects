<?php
require_once('header.php');

//require_once('../Processes/Editor_Details.php');
//require_once('../Processes/Editor/GetData.php');
//var_dump($results);
$id=$_POST["cid"];
$version=$_POST["ver"];
echo '<script> var $id='. json_encode($id) . '</script>';
echo '<script> var $version='. json_encode($version) . '</script>';

?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3>Checklist ID: <?php echo $id?> Version: <?php echo $version; ?></h3> </div>
                 <div class="status" style="color: Red;?>;">
                <h3>Draft</h3> </div>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form"> <a href="ChecklistReorder.php?cid=<?php echo $id.'&ver='.$version;?>" class="btn btn-default">Reorder Steps</a> </form>
                </li>
                <li>
                    <form class="navbar-form"> <a href="ChecklistDetails.php?cid=<?php echo $id.'&ver='.$version;?>" class="btn btn-default">Back to Details</a> </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="NewStep" class="modal fade">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>New Step</h2> </div>
                        <div class="modal-body">
                            <form action="#" method="post" id="addStep">
                                <textarea name="step" id="content" cols="30" rows="15" class="TinyMCE"></textarea>
                                <div class="modal-footer">
                                <input id="submit" class="btn btn-primary" type="submit" data-dismiss="modal" value="Save">
                                <input id="Cancel" class="btn btn-danger" type="button" onclick="clear()" data-dismiss="modal" value="Cancel">
                                </div> </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loaderImage"> <img src="../js/ajax-loader.gif" alt=""> </div>
            <div class="container">
                <div id="pageContent"> </div>
                <br>
                 <a href="#" class="add-btn btn btn-success" data-toggle="modal" data-target="#NewStep">Add Step</a> </div>
        </div>
        <script src="../../Globals/js/tinymce.min.js"></script>
        <script src="../js/script.js"></script>
    </div>