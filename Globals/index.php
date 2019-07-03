<?php
//echo strtoupper(trim($_SERVER['LOGON_USER'],'MEDITECH\\'));
var_dump($_SERVER);
?>
<br>
<br>
<?php
echo strtoupper(ltrim($_SERVER['LOGON_USER'],'MEDITECH\\'));?>

<br>
<?php
echo strtoupper($_SERVER['LOGON_USER']);

