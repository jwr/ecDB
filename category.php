<?php
	require_once('include/login/auth.php');
	require_once('include/debug.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Category - ecDB</title>
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
				<div class="subMenu">
					<ul>
						<?php
							include('include/include_category_head.php');

							$Head = new NameHead;
							$Head->Head();
						?>
					</ul>
				</div>
				<div class="subSubMenu">
					<ul>
						<?php
							include('include/include_category_sub.php');

							$Sub = new NameSub;
							$Sub->Sub();
						?>
					</ul>
				</div>

				<table class="globalTables" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th></th>
							<th><a href="?
								<?php	if(isset($_GET['subcat'])) {
											echo 'subcat';
										}
										else {
											echo 'cat';
										}
								?>
								=
								<?php	if(isset($_GET['cat'])) {
											echo $_GET['cat'];
										}
										if(isset($_GET['subcat'])) {
											echo $_GET['subcat'];
										}
								?>
								&by=name&order=
								<?php	if(isset($_GET['order'])) {
											$order = $_GET['order'];
											if ($order == 'asc') {	
												echo 'desc'; 
											} 
											else { 
												echo 'asc'; 
											} 
										} 
										else {
											echo 'desc'; 
										} 
								?>
								">Name</a></th>

							<th><a href="?<?php if(isset($_GET['subcat'])) {echo 'subcat';}else {echo 'cat';} ?>=<?php if(isset($_GET['cat'])){ echo $_GET['cat'];} if(isset($_GET['subcat'])){ echo $_GET['subcat'];} ?>&by=category&order=<?php if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') {	echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; } ?>">Category</a></th>

							<th><a href="?<?php if(isset($_GET['subcat'])) {echo 'subcat';}else {echo 'cat';} ?>=<?php if(isset($_GET['cat'])){ echo $_GET['cat'];} if(isset($_GET['subcat'])){ echo $_GET['subcat'];} ?>&by=package&order=<?php if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') {	echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; } ?>">Package</a></th>

							<th><a href="?<?php if(isset($_GET['subcat'])) {echo 'subcat';}else {echo 'cat';} ?>=<?php if(isset($_GET['cat'])){ echo $_GET['cat'];} if(isset($_GET['subcat'])){ echo $_GET['subcat'];} ?>&by=pins&order=<?php if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') {	echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; } ?>">Pins</a></th>

							<th>Image</th>
							<th>Datasheet</th>

							<th><a href="?<?php if(isset($_GET['subcat'])) {echo 'subcat';}else {echo 'cat';} ?>=<?php if(isset($_GET['cat'])){ echo $_GET['cat'];} if(isset($_GET['subcat'])){ echo $_GET['subcat'];} ?>&by=smd&order=<?php if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') {	echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; } ?>">SMD</a></th>

							<th><a href="?<?php if(isset($_GET['subcat'])) {echo 'subcat';}else {echo 'cat';} ?>=<?php if(isset($_GET['cat'])){ echo $_GET['cat'];} if(isset($_GET['subcat'])){ echo $_GET['subcat'];} ?>&by=price&order=<?php if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') {	echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; } ?>">Price</a></th>

							<th><a href="?<?php if(isset($_GET['subcat'])) {echo 'subcat';}else {echo 'cat';} ?>=<?php if(isset($_GET['cat'])){ echo $_GET['cat'];} if(isset($_GET['subcat'])){ echo $_GET['subcat'];} ?>&by=quantity&order=<?php if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') {	echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; } ?>">Quantity</a></th>
							<th>Comment</th>
						</tr>
					</thead>
					<tbody>
						<?php
							include('include/include.php');
							$Category = new ShowComponents;
							$Category->Category();
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
