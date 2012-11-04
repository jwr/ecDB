<?php
	require_once('include/login/auth.php');
	require_once('include/debug.php');
	
	if(isset($_GET['id'])) {
		$id = (int)$_GET['id'];
		
		if ($id == 1) {
			$message = "You don't have permission to view this component.";
		}
		elseif ($id == 2) {
			$message = "You don't have permission to edit this component.";
		}
		elseif ($id == 3) {
			$message = "Oh crap! Something broke...";
		}
		else {
			$message = "";
		}
	}
	if (empty($_GET['id'])) {
		$message = 'Error!';
	}
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Error - ecDB</title>
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
					<div class="message red">
						<?php echo $message; ?>
					</div>
				</div>
			<!-- END -->
			<!-- Text outside the main content -->
				<?php include 'include/footer.php'; ?>
			<!-- END -->
		</div>
	</body>
</html>
