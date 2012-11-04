<?php

// This sets PHP errors on or off.

$debug = 0; // 1 = debug

if ($debug == 1){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}
?>
