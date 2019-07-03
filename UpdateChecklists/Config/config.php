<?php
if($_SERVER['SERVER_NAME'] === "staff-test.meditech.com"){
define('DB_HOST','atdmariadbtest.meditech.com');
define('DB_USER','swatUser');
define('DB_PASS','clientSERVICESsWaT');
define('DB_NAME','SWAT_UpdateChecklists');
define('MAIN_TABLE','LogChecklist');
}elseif($_SERVER['SERVER_NAME'] === "staff.meditech.com"){
    define('DB_HOST','atdmariadblive.meditech.com');
    define('DB_USER','swatUser');
    define('DB_PASS','clientSERVICESsWaT');
    define('DB_NAME','SWAT_UpdateChecklists');
    define('MAIN_TABLE','LogChecklist');
}else{
    define('DB_HOST','atdmariadbtest.meditech.com');
    define('DB_USER','swatUser');
    define('DB_PASS','clientSERVICESsWaT');
    define('DB_NAME','SWAT_UpdateChecklists');
    define('MAIN_TABLE','LogChecklist');
}


