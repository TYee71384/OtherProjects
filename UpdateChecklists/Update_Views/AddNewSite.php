<?php require_once('header.php');
$platform = Query("Select ProdLine from ListProdLine");
?>
<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <h3>Add New Site</h3> </div>
        </div>
    </nav>

<form method="POST" action="../Update_Processes/AddNewSite.php">
<div class="row">
<div class="container">
<div class="col-md-2 form-group">
                    <label>Platform</label>
                    <select class="form-control" name="ProdLine" required>
                        <option value="">------</option>
                        <?php foreach($platform as $ddl): ?>
                            <option>
                                <?php echo $ddl->ProdLine;?>
                            </option>
                            <?php endforeach; ?>
                    </select>
               
</div>
<div class="col-md-2 form-group">
<label for="SteKml">Site Mnemonic</label>
<input type="text" class="form-control" name="SiteKml" required >
</div>
<div class="col-md-6 form-group">
<label for="SteKml">Site Name</label>
<input type="text" class="form-control" name="SiteName" required >
</div>

</div>
<button type="submit" class="btn btn-primary">Save</button>
<button type="reset" class="btn btn-danger">Cancel</button>
</div>
</form>
<br>
<div class="row col-md-offset-2">
<p class=" text-center bg-danger col-md-9">
This page is for adding sites only. If you need to edit an existing site, please contact Tom Yee x 3091
</p>
</div>
