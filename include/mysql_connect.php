<?php
	$db_host = "localhost";
	$db_username = "username";
	$db_pass = "password";
	$db_name = "databasename";

	mysql_pconnect($db_host, $db_username, $db_pass) or die ("Could not connect connect to MySQL Server");
	mysql_select_db($db_name) or die ("No database");
	mysql_set_charset('utf8');
?>