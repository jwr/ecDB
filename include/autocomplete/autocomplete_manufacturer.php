<?php
require_once "../mysql_connect.php";
$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "select DISTINCT manufacturer as manufacturer from data where manufacturer LIKE '%$q%' ORDER by name ASC";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$manufacturer = $rs['manufacturer'];
	echo "$manufacturer\n";
}
?>