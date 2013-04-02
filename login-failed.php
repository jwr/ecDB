<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Login - ecDB</title>
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
					<li><a href="."><span class="icon medium key" class="selected"></span> Login</a></li>
					<li><a href="register.php"><span class="icon medium user"></span> Register</a></li>
					<li><a href="about.php"><span class="icon medium document"></span> About</a></li>
					<li><a href="/blog"><span class="icon medium docLinesStright"></span> Blog</a></li>
				</ul>
			</div>
			<!-- END -->
			
			<!-- Main content -->
			<div id="content">
				
				<div class="message red">
					Login failed, please try again.
				</div>
				
				<div class="loginWrapper">
					<div class="left">
						<div class="aboutECDB"></div>
						
						<form class="globalForms" name="loginForm" method="post" action="login-exec.php">
							<div class="textInput">
								<label class="keyWord">Username</label>
								<div class="input"><input name="login" class="medium" type="text" id="login"/></div>
							</div>
							<div class="textInput">
								<label class="keyWord">Password</label>
								<div class="input"><input name="password" class="medium" type="password" id="password"/></div>
							</div>
							<div class="buttons">
								<div class="input">
									<button class="button green" name="Submit" type="submit"><span class="icon medium key"></span> Login</button>
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
