<?php
	//Start session
	session_start();
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		if ($_SERVER["REQUEST_URI"] == '/contact.php' or $_SERVER["REQUEST_URI"] == '/terms.php'){
			
		}
		else {
			header("location: login.php");
			exit();
		}
	}
?>