<?php
require_once "../mysql_connect.php";
include ('../login/auth.php');
$q = strtolower($_GET["q"]);
if (!$q) return;

$owner	=	$_SESSION['SESS_MEMBER_ID'];
			
$user_setting_auto_complete = mysql_query("SELECT auto_complete FROM members WHERE member_id = ".$owner."");

if(mysql_fetch_array($user_setting_auto_complete)['auto_complete'] == "user"){
	$sql = "select DISTINCT package as package from data where package LIKE '%$q%' ORDER by name ASC";
}
else{
	$sql = "select DISTINCT package as package from data where package LIKE '%$q%' ORDER by name ASC";
}
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$cname = $rs['package'];
	echo "$cname\n";
}
?>
