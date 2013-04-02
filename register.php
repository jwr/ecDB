<?php
	session_start();
	require_once('include/debug.php');
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Register - ecDB</title>
		<?php include_once("include/analytics.php") ?>
		
	</head>
	
	<body>
		<div id="wrapper">
			
			<!-- Header -->
			<div id="header">
				<div class="logoWrapper">
					<a href ="."><span class="logoImage"></span></a>
				</div>
			</div>
			<!-- END -->
			
			<!-- Main menu -->
			<div id="menu">
				<ul>
					<li><a href="index.php"><span class="icon medium key"></span> Login</a></li>
					<li><a class="selected"><span class="icon medium user"></span> Register</a></li>
					<li><a href="about.php"><span class="icon medium document"></span> About</a></li>
					<li><a href="/blog"><span class="icon medium docLinesStright"></span> Blog</a></li>
				</ul>
			</div>
			<!-- END -->
			
			<!-- Main content -->
			<div id="content">
				
				<?php
					if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
						echo '<div class="message red">';
						echo '<ul class="error">';
						foreach($_SESSION['ERRMSG_ARR'] as $msg) {
							echo '<li>',$msg,'</li>'; 
						}
						echo '</ul>';
						echo '</div>';
						unset($_SESSION['ERRMSG_ARR']);
					}
				?>
				<div class="loginWrapper">
					<div class="left">
						<div class="aboutECDB">
							You want to build something and need some components for your project. 
							You don't know if you have those components, or where they are.
							This is a problem many of us recognise. 
							We want to change that for you by making a online inventory system for your electronic components that is easy to use. 
							Add your components. Search to find it, and then use it!
						</div>
						<form class="globalForms" name="loginForm" method="post" action="register-exec.php">
							<div class="textInput">
								<label class="keyWord">First name</label>
								<div class="input"><input name="fname" type="text" class="medium" id="fname" /></div>
							</div>
							<div class="textInput">
								<label class="keyWord">Last name</label>
								<div class="input"><input name="lname" type="text" class="medium" id="lname" /></div>
							</div>
							<div class="textInput">
								<label class="keyWord">Username</label>
								<div class="input"><input name="login" type="text" class="medium" id="login" /></div>
							</div>
							<div class="textInput">
								<label class="keyWord">E-mail</label>
								<div class="input"><input name="mail" type="text" class="medium" id="mail" /></div>
							</div>
							<div class="textInput">
								<label class="keyWord">Password</label>
								<div class="input"><input name="password" type="password" class="medium" id="password" /></div>
							</div>
							<div class="textInput">
								<label class="keyWord">Repeat password</label>
								<div class="input"><input name="cpassword" type="password" class="medium" id="cpassword" onpaste="return false;" /></div>
							</div>
							<div class="buttons">
								By registering you accept the <a href="terms.php">Terms and Contidions.</a><br><br>
								<div class="input">
									<button class="button green" name="Submit" type="submit">Register</button>
								</div>
							</div>
						</form>
					</div>
					<div class="right"></div>
				</div>
			</div>
			<!-- END -->
			
			<!-- Text outside the main content -->
				<?php include 'include/footer.php'; ?>
			<!-- END -->
			
		</div>
	</body>
</html>
