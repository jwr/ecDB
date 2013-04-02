<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
				<span class="loggo">
					<span class="ec">ec</span><span class="db">DB</span>
				</span>
				<span class="beta">beta</span>
				<span class="slogan">
					Electronic<br>
					Components<br>
					DataBase
				</span>
			</div>
			<!-- END -->
			
			<!-- Main menu -->
			<div id="menu">
				<ul>
					<li><a href="."><span class="icon medium key"></span> Login</a></li>
					<li><a href="register.php" class="selected"><span class="icon medium user"></span> Register</a></li>
					<li><a href="about.php"><span class="icon medium document"></span> About</a></li>
					<li><a href="/blog"><span class="icon medium docLinesStright"></span> Blog</a></li>
				</ul>
			</div>
			<!-- END -->
			
			<!-- Main content -->
			<div id="content">
				
				<h1>Registration success</h1>
				
				<b>Please login</b><br /><br />
				
				<form id="loginForm" name="loginForm" method="post" action="login-exec.php">
					<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
						<tr>
							<td width="112">Login</td>
							<td width="188"><input name="login" type="text" class="textfield" id="login" /></td>
						</tr>
						<tr>
							<td>Password</td>
							<td><input name="password" type="password" class="textfield" id="password" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="Submit" value=" Login " /></td>
						</tr>
					</table>
				</form>
			</div>
			<!-- END -->
			
			<!-- Text outside the main content -->
				<?php include 'include/footer.php'; ?>
			<!-- END -->
			
		</div>
	</body>
</html>
