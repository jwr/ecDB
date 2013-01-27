<?php
	require_once('include/login/auth.php');
	require_once('include/debug.php');
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="description" content="Add your projects here. You will then be able to add components to them and creat BOM-list."/>
		<meta name="keywords" content="electronics, components, database, project, inventory"/> 
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
					<?php
						include('include/include_proj_add.php');
						$AddProj = new ProjAdd;
						$AddProj->AddProj();
						
						$proj_query = mysql_query("SELECT * FROM projects WHERE project_owner= $owner");
						if(mysql_num_rows($proj_query) == 0){
							echo '<div class="message orange">To create a BOM-list (Bill Of Material) you have to first create a project. You will then be able to add your components to your project and automaticly create a BOM-list.</div>';
						}
					?>
					<form class="globalForms" method="post" action="">
						<div class="textInput">
							<label class="keyWord">Project name</label>
							<div class="input"><input name="name" id="name" type="text" class="medium" /></div>
						</div>
						<div class="buttons">
							<div class="input">
								<button class="button green" name="submit" type="submit"><span class="icon medium save"></span> Add project</button>
							</div>
						</div>
					</form>
					
					<hr>
						
					<table class="globalTables" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th></th>
								<th><a href="?by=name&order=<?php 
								if(isset($_GET['order'])){
									$order = $_GET['order'];
									if ($order == 'asc'){
										echo 'desc';
									}
									else {
										echo 'asc';
									}
								}
								else {
									echo 'desc';
								}
								?>">Name</a>
								</th>
								<th>Number of components</th>
								<th>Total cost</th>
							</tr>
						</thead>
						<tbody>
							<?php
								include('include/include_proj_list_projets.php');
								$ProjList = new Proj;
								$ProjList->ProjList();
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
