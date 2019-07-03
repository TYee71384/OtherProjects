<?php
$id=$_GET["UID"];
require_once('header.php');
require_once('../Update_Processes/UpdateDetails_Load.php');

?>

 <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3><?php echo $data->ProdLine;?>
                <?php echo $data->SiteKml;?> : <?php if(!empty($data->UpdateNum)) : ?>  Update # <?php echo $data->UpdateNum;?> : <?php endif;?> <?php echo $data->Process;?></h3> </div>
                <ul class="nav navbar-nav" style="color:<?php echo Color($data->Status);?>">
                    <li class="padding-li"><h3><?php echo $data->Status;?></h3></li>
                    <li class="padding-li" id="ProgressBar">
                    </li>
                </ul>
            <ul class="nav navbar-nav navbar-right">
                <li> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><b class="caret"></b></a>
                    <div class="dropdown-menu">
                        <div> <b>Start Time: </b>
                            <?php echo $data->StartTime;?>
                        </div>
                        <div> <b>Last Activity: </b>
                            <?php echo $history->FileTime;?>
                        </div>
                        <div> <b>Last User: </b>
                            <?php echo $history->FileBy;?>
                        </div>
                    </div>
                </li>
                <li class="history-link">
                    <form class="navbar-form"> <a href="UpdateDetails.php?UID=<?php echo $id;?>" class="btn btn-default">Back to Details</a> </form>
                </li>
            </ul>
        </div>
    </nav>
        <table class="table table-condensed table-hover padding">
        <thead>
            <tr>
                <th>File Time</th>
                <th>User</th>
                <th>Activity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="highlight">
            <?php foreach($full_history as $row):?>
                <tr>
                    <td>
                        <?php echo date('m/d/Y H:i:s', strtotime($row->FileTime));?>
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
        </tbody>
</table>
<?php echo '<script> var $id='. json_encode($id) . '</script>';?>
 <script src="../js/updatescript.js"></script>