<?php
  require_once('include/login/auth.php');
	require_once('include/debug.php');
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="description" content="Find your shopping list here."/>
		<meta name="keywords" content="electronics, components, database, project, inventory"/> 
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Component log - ecDB</title>
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
					
					
					
					<table class="globalTables" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th>
								Date
								</th>
								<th>
								Event
								</th>
								<th>
								Quantity
								</th>
								<th>
								Difference
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
								include('include/include_log.php');
								$Log = new Log;
							?>
						</tbody>
					</table>
				</div>
			<!-- END -->
			<!-- Text outside the main content -->
				<?php include 'include/footer.php'; ?>
			<!-- END -->
		</div>
	</body>
</html>
