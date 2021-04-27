<?php
	$db_host = "localhost";
	$db_username = "username";
	$db_pass = "password";
	$db_name = "databasename";

	$link = mysqli_connect($db_host, $db_username, $db_pass) or die ("Could not connect to MySQL Server");
	mysqli_select_db($link, $db_name) or die ("No database");
	mysqli_set_charset($link, 'utf8');
?>
