<?php
require('../../Globals/init.php');
$prodLine = $_POST["platform"];
$query = "SELECT ProdLine,SiteKml FROM ListSite WHERE ProdLine = $prodLine ORDER BY ProdLine,SiteKml";

$Site = Query("SELECT ProdLine,SiteKml FROM ListSite WHERE ProdLine = '$prodLine' ORDER BY ProdLine,SiteKml");

echo "<option value=''>------</option>";
foreach($Site as $ddl){
          echo "<option value='$ddl->SiteKml'>$ddl->SiteKml</option>";
                        
                            }
?>
