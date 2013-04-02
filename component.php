<?php
	require_once('include/login/auth.php');
	include('include/mysql_connect.php');
	require_once('include/debug.php');

	$owner 	= 	$_SESSION['SESS_MEMBER_ID'];
	$id 	= 	(int)$_GET['view'];

	$GetDataComponent = mysql_query("SELECT * FROM data WHERE id = ".$id." AND owner = ".$owner."");
	$executesql = mysql_fetch_assoc($GetDataComponent);

	$GetPersonal = mysql_query("SELECT currency, measurement FROM members WHERE member_id = ".$owner."");
	$personal = mysql_fetch_assoc($GetPersonal);

	if ($executesql['owner'] !== $owner) {
		header("Location: error.php?id=1");
	}

	if ($executesql['category'] < 999) {
		$head_cat_id = substr($executesql['category'], -3, 1);
	}
	else {
		$head_cat_id = substr($executesql['category'], -4, 2);
	}

	$GetHeadCatName = mysql_query("SELECT * FROM category_head WHERE id = ".$head_cat_id."");
	$executesql_head_catname = mysql_fetch_assoc($GetHeadCatName);

	$sub_cat_id = $executesql['category'];

	$GetSubCatName = mysql_query("SELECT * FROM category_sub WHERE id = ".$sub_cat_id."");
	$executesql_sub_catname = mysql_fetch_assoc($GetSubCatName);

	if(isset($_POST['edit'])) {
		header("Location: edit_component.php?edit=$id");
	}

	if(isset($_POST['delete'])) {
		$sqlDeleteComopnent = "DELETE FROM data WHERE id = ".$id." ";
		$sql_exec_component_delete = mysql_query($sqlDeleteComopnent);

		$sqlDeleteProject = "DELETE FROM projects_data WHERE projects_data_component_id = '$id'";
		$sql_exec_project_delete = mysql_query($sqlDeleteProject);

		header("Location: .");
	}

	if (isset($_POST['based'])) {
		header("Location: add_based.php?based=$id");
	}

	if (isset($_POST['quantity_increase'])) {
		$quantity_before	=	$executesql['quantity'];
		$quantity_after		= 	$quantity_before + 1;

		$sql = "UPDATE data SET quantity = '".$quantity_after."' WHERE id = ".$id." ";
		$sql_exec = mysql_query($sql);
		header("location: " . $_SERVER['REQUEST_URI']);
	}

	if (isset($_POST['quantity_decrease'])) {
		$quantity_before	=	$executesql['quantity'];
		$quantity_after 	= 	$quantity_before - 1;

		$sql = "UPDATE data SET quantity = '".$quantity_after."' WHERE id = ".$id." ";
		$sql_exec = mysql_query($sql);
		header("location: " . $_SERVER['REQUEST_URI']);
	}

	if (isset($_POST['orderquant_increase'])) {
		$quantity_before	=	$executesql['order_quantity'];
		$quantity_after		= 	$quantity_before + 1;

		$sql = "UPDATE data SET order_quantity = '".$quantity_after."' WHERE id = ".$id." ";
		$sql_exec = mysql_query($sql);
		header("location: " . $_SERVER['REQUEST_URI']);
	}

	if (isset($_POST['orderquant_decrease'])) {
		$quantity_before	=	$executesql['order_quantity'];
		$quantity_after 	= 	$quantity_before - 1;

		$sql = "UPDATE data SET order_quantity = '".$quantity_after."' WHERE id = ".$id." ";
		$sql_exec = mysql_query($sql);
		header("location: " . $_SERVER['REQUEST_URI']);
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="description" content="Information of <?php echo $executesql['name']; ?> component."/>
		<meta name="keywords" content="electronics, components, database, project, inventory"/>
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>View component - <?php echo $executesql['name']; ?> - ecDB</title>
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
				<h1>
				<a href="category.php?cat=
					<?php
						echo $executesql_head_catname['id'];
						echo '"> ';
						echo $executesql_head_catname['name'];
						echo '</a> / ';

						echo '<a href="category.php?subcat=';
						echo $executesql_sub_catname['id'];
						echo '"> ';
						echo $executesql_sub_catname['name'];
					?>
				</a> / <?php echo $executesql['name']; ?>
				</h1>
				
				<div class="aboutComponentHeader">
					<div class="componentGallery">
						<div class="bigImage">
							<?php
								if ($executesql['url1'] == "") {
									echo '<div class="componentNoImg">';
									echo 'No Image';
									echo '</div>';
								}
								else {
									echo '<a href="';
									echo $executesql['url1'];
									echo '" target="_blank"><img src="';
									echo $executesql['url1'];
									echo '" alt=""/></a>';
								}
							?>
						</div>
						<div class="smallImages">
							<ul>
								<?php
									if ($executesql['url2'] == "") {
										echo "";
									}
									else {
										echo '<li><a href="';
										echo $executesql['url2'];
										echo '" target="_blank"><img src="';
										echo $executesql['url2'];
										echo '" alt=""/></a></li>';
									}
								?>
								<?php
									if ($executesql['url3'] == "") {
										echo "";
									}
									else {
										echo '<li><a href="';
										echo $executesql['url3'];
										echo '" target="_blank"><img src="';
										echo $executesql['url3'];
										echo '" alt=""/></a></li>';
									}
								?>
								<?php
									if ($executesql['url4'] == "") {
										echo "";
									}
									else {
										echo '<li><a href="';
										echo $executesql['url4'];
										echo '" target="_blank"><img src="';
										echo $executesql['url4'];
										echo '" alt=""/></a></li>';
									}
								?>
							</ul>
						</div>
					</div>
	
					<div class="componentComment">
						<?php echo nl2br($executesql['comment']); ?>
					</div>
				</div>
				
				<div class="componetInfo">
					<table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="boldText">Location</td>
								<td>
									<?php
										if ($executesql['location'] == "") {
											echo "-";
										}
										else {
											echo $executesql['location'];
										}
									?>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">Quantity</td>
								<td>
									<?php
										if ($executesql['quantity'] == "") {
											echo "-";
										}
										else {
											echo $executesql['quantity'];
										}
									?>
									<form class="globalForms inLine" method="post" action="">
										<button class="button white small" name="quantity_increase" type="submit"><span class="icon medium roundPlus"></span></button>
										<button class="button white small" name="quantity_decrease" type="submit"><span class="icon medium roundMinus"></span></button>
									</form>
								</td>
								<td class="boldText">Price</td>
								<td>
									<?php
										if ($executesql['price'] == "") {
											echo "-";
										}
										else {
											echo $executesql['price'];
											echo ' ';
											echo $personal['currency'];
										}
									?>
								</td>
								<td class="boldText">Order quantity</td>
								<td>
									<?php
										if ($executesql['order_quantity'] == "") {
											echo "0";
										}
										else {
											echo $executesql['order_quantity'];
										}
									?>
									<form class="globalForms inLine" method="post" action="">
										<button class="button white small" name="orderquant_increase" type="submit"><span class="icon medium roundPlus"></span></button>
										<button class="button white small" name="orderquant_decrease" type="submit"><span class="icon medium roundMinus"></span></button>
									</form>
								</td>
							</tr>
							<tr>
								<td class="boldText">Manufacturer</td>
								<td>
									<?php
										if ($executesql['manufacturer'] == "") {
											echo "-";
										}
										else {
											echo $executesql['manufacturer'];
										}
									?>
								</td>
								<td class="boldText">Package</td>
								<td>
									<?php
										if ($executesql['package'] == "") {
											echo "-";
										}
										else {
											echo $executesql['package'];
										}
									?>
								</td>
								<td class="boldText">Pins</td>
								<td>
									<?php
										if ($executesql['pins'] == "") {
											echo "-";
										}
										else {
											echo $executesql['pins'];
										}
									?>
								</td>
							</tr>
							<tr>
								<td class="boldText">SMD</td>
								<td>
									<?php
										if ($executesql['smd'] == "Yes") {
											echo '<span class="icon medium checkboxChecked"></span>';
										}
										else {
											echo '<span class="icon medium checkboxUnchecked"></span>';
										}
									?>
								</td>
								<td class="boldText">Scrap</td>
								<td>
									<?php
										if ($executesql['scrap'] == "Yes") {
											echo '<span class="icon medium checkboxChecked"></span>';
										}
										else {
											echo '<span class="icon medium checkboxUnchecked"></span>';
										}
									?>
								</td>
								<td class="boldText">Public</td>
								<td>
									<?php
										if ($executesql['public'] == "Yes") {
											echo '<span class="icon medium checkboxChecked"></span>';
										}
										else {
											echo '<span class="icon medium checkboxUnchecked"></span>';
										}
									?>
								</td>
							</tr>
							<tr>
								<td class="boldText">Width</td>
								<td>
									<?php
										if ($executesql['width'] == "") {
											echo "-";
										}
										else {
											echo $executesql['width'];
												if($personal['measurement'] == 1){
													echo ' mm';
												}
												else {
													echo ' "';
												}
										}
									?>
								</td>
								<td class="boldText">Weight</td>
								<td>
									<?php
										if ($executesql['weight'] == "") {
											echo "-";
										}
										else {
											echo $executesql['weight'];
												if($personal['measurement'] == 1){
													echo ' g';
												}
												else {
													echo ' g';
												}
										}
									?>
								</td>
								<td class="boldText"></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">Depth</td>
								<td>
									<?php
										if ($executesql['depth'] == "") {
											echo "-";
										}
										else {
											echo $executesql['depth'];
												if($personal['measurement'] == 1){
													echo ' mm';
												}
												else {
													echo ' "';
												}
										}
									?>
								</td>
								<td class="boldText"></td>
								<td>
								</td>
								<td class="boldText"></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">Height</td>
								<td>
									<?php
										if ($executesql['height'] == "") {
											echo "-";
										}
										else {
											echo $executesql['height'];
												if($personal['measurement'] == 1){
													echo ' mm';
												}
												else {
													echo ' "';
												}
										}
									?>
								</td>
								<td class="boldText"></td>
								<td>
								</td>
								<td class="boldText"></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">Datasheet</td>
								<td>
									<?php
										if ($executesql['datasheet'] == "") {
											echo "-";
										}
										else {
											echo '<a href="';
											echo $executesql['datasheet'];
											echo '" target="_blank"><span class="icon medium document"></a>';
										}
									?>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>

				<form class="globalForms noPadding" method="post" action="">
					<div class="buttons">
						<div class="input">
							<button class="button" name="edit" type="submit"><span class="icon medium pencil"></span> Edit Component</button>
							<button class="button" name="based" type="submit"><span class="icon medium sqPlus"></span> New based on this</button>
							<button class="button red" name="delete" type="submit"><span class="icon medium trash"></span> Delete component</button>
						</div>
					</div>
				</form>
				<!--
				<div class="componentLog">
					<h1><span class="icon medium docLinesStright"></span> Component log <span class="text colorGray styleItalic fontSizeMedium">(last two actions)</h1>
					<div class="logsMenu"><a>Show/Hide all</a></div>
					<div class="logs">
						<table class="globalTables" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th>
										Time
									</th>
									<th>
										Action
									</th>
									<th>
										Who
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>2013-02-02 00:08</td>
									<td>Added component image</td>
									<td>Adis</td>
								</tr>
								<tr>
									<td>2013-02-02 00:08</td>
									<td>Added component image</td>
									<td>Adis</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="logsMenu"><a>Show/Hide all</a></div>
				</div>
				-->
			</div>
			<!-- END -->
			<!-- Text outside the main content -->
					<?php include 'include/footer.php'; ?>
			<!-- END -->
		</div>
	</body>
</html>
