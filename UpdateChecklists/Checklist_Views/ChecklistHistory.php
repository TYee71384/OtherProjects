<?php
$title = 'Checklist History';
require_once('header.php');

$id = $_GET["cid"];
$version = $_GET["ver"];

$query = "SELECT * FROM LogChecklist WHERE IDchecklist=" . $id . " AND Version=" . $version;
$data = Query($query,1);
$history = Query("SELECT * FROM LogChecklistHistory WHERE IDchecklist=" . $id . " AND Version=" . $version . " ORDER BY FileTime ASC");

function color($status){
    switch($status){
        case 'Archived';
    return 'gray';
    break;
        case 'Approved';
            return 'Green';
            break;
        case 'Draft';
            return 'Red';
            break;
    }
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
                    <form class="navbar-form"> <a href="ChecklistDetails.php?cid=<?php echo $id.'&ver='.$version;?>" class="btn btn-default">Back to Details</a> </form>
                </li>
            </ul>
        </div>
    </nav>
    <table class="table table-condensed table-hover">
        <thead>
            <tr>
                <th>File Time</th>
                <th>User</th>
                <th>Activity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="highlight">
            <?php foreach($history as $row):?>
                <tr>
                    <td>
                        <?php echo date("m/d/Y H:i:s",strtotime($row->FileTime));?>
                    </td>
                    <td>
                        <?php echo $row->FileBy?>
                    </td>
                    <td>
                        <?php echo $row->FileAction;?>
                    </td>
                    <td>
                        <?php echo $row->Status;?>
                    </td>
                </tr>
                <?php endforeach;?>