<?php
	require_once('include/login/auth.php');
	include('include/mysql_connect.php');
	require_once('include/debug.php');
	
	$owner 	= 	$_SESSION['SESS_MEMBER_ID'];
	$id 	= 	(int)$_GET['based'];

	// Get data from the old component to inherit.
	$GetDataComponent = mysql_query("SELECT * FROM data WHERE id = ".$id." AND owner = ".$owner.""); 
	$executesql = mysql_fetch_assoc($GetDataComponent);
	
	// Get some personal data. ID, currency, measurement unit
	$GetPersonal = mysql_query("SELECT currency, measurement FROM members WHERE member_id = ".$owner.""); 
	$personal = mysql_fetch_assoc($GetPersonal);
	
	// If the owner of component !== $owner. Show error.
	if ($executesql['owner'] !== $owner) {
		header("Location: error.php?id=2");
	}

	// Get the head category ID, based of the sub category, ($executesql['category']).
	if ($executesql['category'] < 999) {
		$head_cat_id = substr($executesql['category'], -3, 1);
	}
	else {
		$head_cat_id = substr($executesql['category'], -4, 2);
	}

	// Get the head category name, based of the head category ID.
	$GetHeadCatName = mysql_query("SELECT * FROM category_head WHERE id = ".$head_cat_id."");
	$executesql_head_catname = mysql_fetch_assoc($GetHeadCatName);

	// Sub category == $sub_cat_id
	$sub_cat_id = $executesql['category'];
	
	// Get the sub category name, based of the sub category ID.
	$GetSubCatName = mysql_query("SELECT * FROM category_sub WHERE id = ".$sub_cat_id."");
	$executesql_sub_catname = mysql_fetch_assoc($GetSubCatName);
	
	// Get ALL the sub categories.
	$GetDataComponentsAll = "SELECT * FROM category_sub";
	$sql_exec = mysql_Query($GetDataComponentsAll);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="description" content="Add a new component based on <?php echo $executesql['name']; ?>."/>
		<meta name="keywords" content="electronics, components, database, project, inventory"/> 
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Add component - ecDB</title>
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
				
				<h1>Add new component based on <a href="component.php?view=<?php echo $executesql['id']; ?>"><?php echo $executesql['name']; ?></a></h1>
				
				<?php
					include('include/include.php');
					$Add = new ShowComponents;
					$Add->Add();
				?>
				
				<form class="globalForms noPadding" action="" method="post">
					<div class="textBoxInput">
						<label class="keyWord boldText">Comment</label>
						<div class="text">
							<textarea name="comment" rows="4"><?php echo $executesql['comment']; ?></textarea>
						</div>
					</div>
					<table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="boldText">
									Name
								</td>
								<td>
									<input name="name" class="medium" type="text" value="<?php echo $executesql['name']; ?>" id="name" />
								</td>
								<td class="boldText">
									Category
								</td>
								<td>
									<select name="category">
										<?php
											$HeadCategoryNameQuery = "SELECT * FROM category_head ORDER by name ASC";
											$sql_exec_headcat = mysql_Query($HeadCategoryNameQuery);
		
											while ($HeadCategory = mysql_fetch_array($sql_exec_headcat)) {
												
												echo '<option class="main_category" value="';
												echo $HeadCategory['id'];
												echo '" disabled>';
												echo $HeadCategory['name'];
												echo '</option>';
												
												$subcatfrom = $HeadCategory['id'] * 100;
												$subcatto = $subcatfrom + 99;
												
												$SubCategoryNameQuery = "SELECT * FROM category_sub WHERE id BETWEEN ".$subcatfrom." AND ".$subcatto." ORDER by name ASC";
												$sql_exec_subcat = mysql_Query($SubCategoryNameQuery);
												
												while ($SubCategory = mysql_fetch_array($sql_exec_subcat)) {
													echo '<option value="';
													echo $SubCategory['id'];
													echo '"';
														if ($executesql_sub_catname['id'] == $SubCategory['id']) {
															echo ' selected';
														}
													echo '>';
													echo $SubCategory['name'];
													echo '</option>';
												}
											}
										?>
									</select>
								</td>
								<td class="boldText">
									Quantity
								</td>
								<td>
									<input name="quantity" type="text" class="small" value="<?php echo $executesql['quantity']; ?>" id="quantity" />
								</td>
							</tr>
							<tr>
								<td class="boldText">
									Manufacturer
								</td>
								<td>
									<input name="manufacturer" class="medium" type="text" value="<?php echo $executesql['manufacturer']; ?>" />
								</td>
								<td class="boldText">
									Package
								</td>
								<td>
									<input name="package" class="medium" type="text" value="<?php echo $executesql['package']; ?>" />
								</td>
								<td class="boldText">
									Pins
								</td>
								<td>
									<input name="pins" type="text" class="small" value="<?php echo $executesql['pins']; ?>" />
								</td>
							</tr>
							<tr>
								<td class="boldText">
									Location
								</td>
								<td>
									<input name="location" type="text" class="medium" value="<?php echo $executesql['location']; ?>" id="location" />
								</td>
								<td class="boldText">
									Price
								</td>
								<td>
									<input name="price" type="text" class="small" value="<?php echo $executesql['price']; ?>" id="price" /> <?php echo $personal['currency']; ?>
								</td>
								<td class="boldText">
									To order
								</td>
								<td>
									<input name="orderquant" type="text" class="small" value="<?php echo $executesql['order_quantity']; ?>" id="orderquant" />
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">
									SMD
								</td>
								<td>
									<?php
										if($executesql['smd'] == 'Yes'){
											echo '<input type="radio" name="smd" value="Yes" checked="checked" /> Yes ';
											echo '<input type="radio" name="smd" value="No" /> No';
										}
										else{
											echo '<input type="radio" name="smd" value="Yes" /> Yes ';
											echo '<input type="radio" name="smd" value="No" checked="checked" /> No';
										}
									?>
								</td>
								<td class="boldText">
									Scrap
								</td>
								<td>
									<?php
										if($executesql['scrap'] == 'Yes'){
											echo '<input type="radio" name="scrap" value="Yes" checked="checked" /> Yes ';
											echo '<input type="radio" name="scrap" value="No" /> No';
										}
										else{
											echo '<input type="radio" name="scrap" value="Yes" /> Yes ';
											echo '<input type="radio" name="scrap" value="No" checked="checked" /> No';
										}
									?>
								</td>
								<td class="boldText">
									Public
								</td>
								<td>
									<?php
										if($executesql['public'] == 'Yes'){
											echo '<input type="radio" name="public" value="Yes" checked="checked" /> Yes ';
											echo '<input type="radio" name="public" value="No" /> No';
										}
										else{
											echo '<input type="radio" name="public" value="Yes" /> Yes ';
											echo '<input type="radio" name="public" value="No" checked="checked" /> No';
										}
									?>
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">
									Weight
								</td>
								<td>
									<input name="weight" type="text" class="small" value="<?php echo $executesql['weight']; ?>" /> <?php if($personal['measurement'] == 1){echo 'g';} else {echo 'g'; } ?>
								</td>
								<td class="boldText">
									Width
								</td>
								<td>
									<input name="width" type="text" class="small" value="<?php echo $executesql['width']; ?>" /> <?php if($personal['measurement'] == 1){echo 'mm';} else {echo 'in'; } ?>
								</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td class="boldText">
									Depth
								</td>
								<td>
									<input name="depth" type="text" class="small" value="<?php echo $executesql['depth']; ?>" /> <?php if($personal['measurement'] == 1){echo 'mm';} else {echo 'in'; } ?>
								</td>
								<td><img class="packageImage" border="0" src="img/boxSize.png"/></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">
									Datasheet URL
								</td>
								<td>
									<input name="datasheet" type="text" class="medium" value="<?php echo $executesql['datasheet']; ?>" />
								</td>
								<td class="boldText">
									Height
								</td>
								<td>
									<input name="height" type="text" class="small" value="<?php echo $executesql['height']; ?>" /> <?php if($personal['measurement'] == 1){echo 'mm';} else {echo 'in'; } ?>
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">
									Image URL 1
								</td>
								<td>
									<input name="url1" type="text" class="medium" value="<?php echo $executesql['url1']; ?>" />
								</td>
								<td class="boldText">
									Image URL 2
								</td>
								<td>
									<input name="url2" type="text" class="medium" value="<?php echo $executesql['url2']; ?>"  />
								</td>
								<td>
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td class="boldText">
									Image URL 3
								</td>
								<td>
									<input name="url3" type="text" class="medium" value="<?php echo $executesql['url3']; ?>" />
								</td>
								<td class="boldText">
									Image URL 4
								</td>
								<td>
									<input name="url4" type="text" class="medium" value="<?php echo $executesql['url4']; ?>" />
								</td>
								<td>
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td></td>
								<td  class="boldText">
									Add component to project
								</td>
								<td  class="boldText">
									Quantity
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<select name="project">
										<?php
											include('include/include_component_add_project.php');
											$MenuProj = new AddMenuProj;
											$MenuProj->MenuProj();
										?>
									</select>
								</td>
								<td>
									<input name="projquant" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['projquant']; } ?>" />
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<div class="buttons">
						<div class="input">
							<button class="button green" name="submit" type="submit"><span class="icon medium save"></span> Save</button>
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
