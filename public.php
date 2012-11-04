<?php
	require_once('include/login/auth.php');
	require_once('include/debug.php');
	include('include/mysql_connect.php');
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="description" content="View you component that you offer to the public."/>
		<meta name="keywords" content="electronics, components, database, project, inventory"/> 
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Home - ecDB</title>
		<?php include_once("include/analytics.php") ?>
		
	</head>
	
	<body>
		<div id="wrapper">
			
			<!-- Header -->
				<?php include 'include/header.php'; ?>
			<!-- END -->
			
			<!-- Main menu -->
				<?php include 'include/menu.php'; ?>
			<!-- END -->
			
			<!-- Main content -->
			<div id="content">
				<h1>Public Components</h1>
				
				<div class="message orange">
					When you add a component there is a button called "public". If you choose to set that to yes, it means that other people can see that you own that component.<br /><br />
					
					The thought with that setting is, for example; You are building a project and missed to order one component, to skip expensive shipping costs, long shipping time etc. you just make a quick search on ecDB for that component and contact the owner. Hopefully he is kind enough to send you that component quickly for a small charge.
				</div>
				
				<h1>This function is under development...</h1>
			</div>
			<!-- END -->
			<!-- Text outside the main content -->
				<?php include 'include/footer.php'; ?>
			<!-- END -->
		</div>
	</body>
</html>
