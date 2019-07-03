<?php 
require_once('header.php');

$user = getUser();
if($user == 'CS' || $user == 'MAGIC'){
    header("Location: index.php");
    exit();

}
//Query each List table to populate dropdown selections
$platform = Query("Select ProdLine from ListProdLine");
$system = Query("Select System from ListSystem ORDER BY SortOrder");
$process = Query("Select Process from ListProcess ORDER BY SortOrder");
$release = Query("Select Rel from ListRelease");
$type = Query("Select Type from ListType ORDER BY SortOrder");

?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3>Checklist Builder</h3> </div>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form"> <a href="ChecklistSearch.php" class="btn btn-default">Back to Search</a> </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <form action="../Checklist_Processes/ChecklistBuilder_Process.php" method="post">
            <input type="text" name="Title" class="form-control" placeholder="Title" required>
            <br>
            <div class="col-md-offset-1">
                <div class="col-md-2 form-group">
                    <label>Platform</label>
                    <select class="form-control" name="Platform" required>
                        <option value="">------</option>
                        <?php foreach($platform as $ddl): ?>
                            <option>
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
                            <option>
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
                            <option>
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
                            <option>
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
                            <option>
                                <?php echo $ddl->Type;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <br/>
            <div class="col-md-offset-4">
                <div class="col-md-6">
                    <input type="submit" class="btn btn-primary" name="create" value="Create New Checklist">
                    <input type="reset" class="btn btn-danger" name="reset" value="Reset"> </div>
            </div>
        </form>
        <br> </div>
    <br>
    <div class="col-md-offset-3">
        <p class="bg-danger col-md-8"> 1. Use the Checklist Builder to create a new Checklist template (starting at Version 1)
            <br> 2. The Checklist Builder should only be used to create an initial template
            <br> 3. The Checklist Builder is NOT to be used to create new Versions of existing Checklists
            <br> 4. The Checklist Builder is NOT to be used to start an Update
            <br> </p>
    </div>