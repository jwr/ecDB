<?php
class My {
	public function Settings() {
		
		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
		if(isset($_POST['submit'])) {
			$owner				=	$_SESSION['SESS_MEMBER_ID'];
			
			$GetDataComponent = mysql_query("SELECT passwd FROM members WHERE member_id = ".$owner."");
			$executesql = mysql_fetch_assoc($GetDataComponent);
			
			$firstname			=	strip_tags(mysql_real_escape_string($_POST['firstname']));
			$lastname			=	strip_tags(mysql_real_escape_string($_POST['lastname']));
			
			$mail				=	strip_tags(mysql_real_escape_string($_POST['mail']));
			$oldpass			=	strip_tags(mysql_real_escape_string($_POST['oldpass']));
			$newpass			=	strip_tags(mysql_real_escape_string($_POST['newpass']));
			
			$measurement		=	strip_tags(mysql_real_escape_string($_POST['measurement']));
			$currency			=	strip_tags(mysql_real_escape_string($_POST['currency']));	
			$auto_complete		=	strip_tags(mysql_real_escape_string($_POST['auto_complete']));			

			if ($firstname == '') {
				echo '<div class="message red">';
				echo 'First name missing';
				echo '</div>';
			}
			elseif (strlen($firstname) <= 2) {
				echo '<div class="message red">';
				echo 'Minimum of 2 chars in first name.';
				echo '</div>';
			}
			elseif ($lastname == '') {
				echo '<div class="message red">';
				echo 'Last name missing';
				echo '</div>';
			}
			elseif (strlen($lastname) <= 2) {
				echo '<div class="message red">';
				echo 'Minimum of 2 chars in last name.';
				echo '</div>';
			}
			elseif ($mail == '') {
				echo '<div class="message red">';
				echo 'Mail missing';
				echo '</div>';
			}
			elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
				echo '<div class="message red">';
				echo 'Invalid e-mail address';
				echo '</div>';
			}
			elseif (!empty($oldpass) && !empty($newpass) && $owner == 4) {
				echo '<div class="message red">';
				echo 'Y NO CHANGE PASSWORD FOR THE DEMO ACCOUNT!!11';
				echo '</div>';
			}
			elseif (!empty($oldpass) && !empty($newpass) && $oldpass == '') {
				echo '<div class="message red">';
				echo 'Password missing';
				echo '</div>';
			}
			elseif (!empty($oldpass) && !empty($newpass) && $newpass == '') {
				echo '<div class="message red">';
				echo 'Confirm password missing';
				echo '</div>';
			}
			elseif (!empty($oldpass) && !empty($newpass) && strlen($newpass) <= 5) {
				echo '<div class="message red">';
				echo 'Minimum of 5 chars in password.';
				echo '</div>';
			}
			elseif (!empty($oldpass) && !empty($newpass) && strcmp(md5($oldpass), $executesql['passwd']) != 0 ) {
				echo '<div class="message red">';
				echo 'The password is invalid ';
				echo '</div>';
			}
			else {
				if (!empty($oldpass) && !empty($newpass)) {
					$sql="UPDATE members SET firstname = '$firstname', lastname = '$lastname', mail = '$mail', passwd = '".md5($newpass)."', measurement = '$measurement', currency = '$currency', auto_complete = '$auto_complete' WHERE member_id = '$owner'";
					$sql_exec = mysql_query($sql);
				}
				else {
					$sql="UPDATE members SET firstname = '$firstname', lastname = '$lastname', mail = '$mail', measurement = '$measurement', currency = '$currency', auto_complete = '$auto_complete' WHERE member_id = '$owner'";
					$sql_exec = mysql_query($sql);
				}

				echo '<div class="message green center">';
				echo 'Settings updated!';
				echo '</div>';
			}
		}
	}
}
?>
