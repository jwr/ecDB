<?php
	require_once('include/login/auth.php');
	require_once('include/debug.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Add Project - ecDB</title>
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
				<h1>Add Project</h1>

				<table class="viewComponent" cellpadding="0" cellspacing="0">
					<form action="" method="post">
						<tr>
							<td class="what">Name</td>
							<td><input name="name" id="name" type="text" class="textfield"" /></td>
						</tr>
						
						<tr>
							<td class="what"></td>
							<td></td>
						</tr>

						<tr>
							<td class="what"></td>
							<td><input type="submit" name="submit" class="submit" value="" /></td>
						</tr>
						
						<tr>
							<td class="what"></td>
							<td>
								<?php
									include('include/include_proj_add.php');

									$AddProj = new Proj;
									$AddProj->AddProj();
								?>
							</td>
						</tr>
					</form>
				</table>
				<div class="uploadedImags">
				
				</div>
			</div>
			<!-- END -->
			<!-- Text outside the main content -->
				<?php include 'include/footer.php'; ?>
			<!-- END -->
		</div>
	</body>
</html>