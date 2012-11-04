<?php
	require_once('include/debug.php');
	require_once('include/login/auth.php');
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Contact - ecDB</title>
		<?php include_once("include/analytics.php") ?>
		
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
							echo '<li><a href="/blog">Blog</a></li>';
						echo '</ul>';
					echo '</div>';
					echo '<!-- END -->';
				}
			?>
			<!-- Main content -->
			<div id="content">
				<div class="loginWrapper">
					<div class="left">
						<h1>Contact us</h1>
						If you have any suggestions, questions or what not. Send us an email to info@ecdb.net
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