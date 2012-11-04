<?php
	//require_once('include/debug.php');
	//require_once('include/login/auth.php');
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	echo php_ini_loaded_file();
?>
<?php
//If the form is submitted
if(isset($_POST['submit'])) {

	//Check to make sure that the name field is not empty
	if(trim($_POST['contactname']) == '') {
		$hasError = true;
	} else {
		$name = trim($_POST['contactname']);
	}

	//Check to make sure that the subject field is not empty
	if(trim($_POST['subject']) == '') {
		$hasError = true;
	} else {
		$subject = trim($_POST['subject']);
	}

	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['username']) == '') {
		$username = 'N/A';
	} else {
		$username = trim($_POST['username']);
	}

	//Check to make sure comments were entered
	if(trim($_POST['message']) == '') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['message']));
		} else {
			$comments = trim($_POST['message']);
		}
	}

	//If there is no error, send the email
	if(!isset($hasError)) {
		$emailTo = 'contact@ecdb.net';
		$body = "Name: $name \nEmail: $email \nUsername: $username \n\nSubject: $subject \n\nMessage:\n$comments";
		$headers = 'From: ecDB - Contact form <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Home - ecDB</title>
		<?php include_once("include/analytics.php") ?>
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
		<script src="include/contact/jquery.validate.pack.js" type="text/javascript"></script>

		<script type="text/javascript">
		$(document).ready(function(){
			$("#contactform").validate();
		});
		</script>
	</head>
	
	<body>
		<div id="wrapper">
			<?php
				if(isset($_SESSION['SESS_MEMBER_ID'])){
					echo '<!-- Header -->';
						include 'include/header.php';
					echo '<!-- END -->';
					
					echo '<!-- Main menu -->';
						include 'include/menu.php';
					echo '<!-- END -->';
				}
				else {
					echo '<!-- Header -->';
					echo '<div id="header">';
						echo '<div class="logoWrapper">';
							echo '<a href ="."><span class="logoImage"></span></a>';
						echo '</div>';
					echo '</div>';
					echo '<!-- END -->';
					
					echo '<!-- Main menu -->';
					echo '<div id="menu">';
						echo '<ul>';
							echo '<li><a href=".">Login</a></li>';
							echo '<li><a href="register.php">Register</a></li>';
							echo '<li><a href="about.php">About</a></li>';
						echo '</ul>';
					echo '</div>';
					echo '<!-- END -->';
				}
			?>
			<!-- Main content -->
			<div id="content">
				<h1>Contact us</h1>
				If you have a suggestion for ecDB please use this form to let us know about it!<br /><br />

					<?php
					if(isset($hasError)) { 
						echo '<div class="message red">';
						echo 'Please check if you have filled all the fields with valid information.';
						echo '</div>';
					}
					
					if(isset($emailSent) && $emailSent == true) { 
						echo '<div class="message green">';
						echo 'Thank you ';
						echo $name;
						echo '! <br />Your message was successfully sent.';
						echo '</div>';
					} 
					?>
				
				<form class="globalForms" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="textInput">
						<label class="keyWord">Name</label>
						<div class="input"><input type="text" size="60" name="contactname" id="contactname" value="" /></div>
					</div>
					<div class="textInput">
						<label class="keyWord">Email</label>
						<div class="input"><input type="text" size="60" name="email" id="email" value="" /></div>
					</div>
					<div class="textInput">
						<label class="keyWord">Username (optional)</label>
						<div class="input"><input type="text" size="60" name="username" id="username" value="" /></div>
					</div>
					<div class="textInput">
						<label class="keyWord">Subject</label>
						<div class="input"><input type="text" size="60" name="subject" id="subject" value="" /></div>
					</div>
					<div class="textInput">
						<label class="keyWord">Message</label>
						<div class="input">
							<textarea rows="6" cols="60" name="message" id="message" value="" /></textarea>
						</div>
					</div>
					<div class="buttons">
						<div class="input">
							<button class="button green" name="submit" type="submit">Submit</button>
						</div>
					</div>
				</form>

			</div>
				<!-- END -->
				<!-- Text outside the main content -->
					<?php include 'include/footer.php'; ?>
				<!-- END -->
		</div>
	</body>
</html>
