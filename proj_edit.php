<?php
	require_once('include/login/auth.php');
	include('include/mysql_connect.php');
	require_once('include/debug.php');
	
	$owner 	= 	$_SESSION['SESS_MEMBER_ID'];
	$id 	= 	(int)$_GET['proj_id'];
	
	$GetDataProjectName = mysql_query("SELECT * FROM projects WHERE project_id = ".$id." AND project_owner = ".$owner."");
	$executesql = mysql_fetch_assoc($GetDataProjectName);
	
	if(isset($_POST['delete'])) {
		$sqlDeleteProject = "DELETE FROM projects WHERE project_id = ".$id." ";
		$sql_exec_component_delete = mysql_query($sqlDeleteProject);

		$sqlDeleteProject = "DELETE FROM projects_data WHERE projects_data_project_id = ".$id." ";
		$sql_exec_project_delete = mysql_query($sqlDeleteProject);

		header("Location: .");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Your Projects - ecDB</title>
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
					<h1>Edit Project</h1>
					
					<?php
						include('include/include_proj_update.php');
						$AddProj = new ProjAdd;
						$AddProj->AddProj();
					?>
					
					<form class="globalForms" method="post" action="">
						<div class="textInput">
							<label class="keyWord">Project name</label>
							<div class="input"><input name="name" type="text" class="medium" value="<?php echo $executesql['project_name']; ?>" /></div>
						</div>
						<div class="buttons">
							<div class="input">
								<button class="button green" name="submit" type="submit"><span class="icon medium save"></span> Save</button>
								<button class="button red" name="delete" type="submit"><span class="icon medium trash"></span> Delete</button>
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