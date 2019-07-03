<?php
$approvalAccess = '';
require_once "../../Globals/init.php";
//Check to see if User has approval access to see if Admin Complete should show up
$currentUser = getUser();
$approval = Query("SELECT UserApprove FROM ListUserApprove WHERE UCase(UserApprove)='" . $currentUser . "'");
if($approval){
   $SiteInfo = array(
    'ProdLine'=> $_POST['ProdLine'],
    'SiteKml' => $_POST['SiteKml'],
    'SiteName' => $_POST['SiteName'],
    );

    
Create($SiteInfo,'ListSite'); 
//var_dump($SiteInfo);
header("Location: ../Update_views/UpdateSearch.php");
exit();
}


