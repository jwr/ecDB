<?php
	require_once('include/login/auth.php');
	require_once('include/mysql_connect.php');
	require_once('include/debug.php');
	
	// Get some personal data. ID, currency, measurement unit
	$owner 	= 	$_SESSION['SESS_MEMBER_ID'];
	$GetPersonal = mysql_query("SELECT currency, measurement FROM members WHERE member_id = ".$owner."");
	$personal = mysql_fetch_assoc($GetPersonal);
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" media="screen"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="description" content="Add a component to your database."/>
		<meta name="keywords" content="electronics, components, database, project, inventory"/> 
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="img/apple.png" />
		<title>Add component - ecDB</title>
		
		<script type="text/javascript" src="include/autocomplete/jquery.js"></script>
		<script type="text/javascript" src="include/autocomplete/jquery.autocomplete.js"></script>
		<link rel="stylesheet" type="text/css" href="include/autocomplete/jquery.autocomplete.css" />

		<script type="text/javascript">
			$().ready(function() {
				$("#name").autocomplete("include/autocomplete/autocomplete_name.php", {
					width: 150,
					matchContains: true,
					minChars: 2,
					selectFirst: false
				});
			});
		</script>
		<script type="text/javascript">
			$().ready(function() {
				$("#package").autocomplete("include/autocomplete/autocomplete_package.php", {
					width: 150,
					matchContains: true,
					minChars: 2,
					selectFirst: false
				});
			});
		</script>
		<script type="text/javascript">
			$().ready(function() {
				$("#manufacturer").autocomplete("include/autocomplete/autocomplete_manufacturer.php", {
					width: 150,
					matchContains: true,
					minChars: 2,
					selectFirst: false
				});
			});
		</script>
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
					include('include/include.php');
					$Add = new ShowComponents;
					$Add->Add();
				?>
				
				
				<form class="globalForms noPadding" action="" method="post">
					<div class="textBoxInput">
						<label class="keyWord boldText">Comment</label>
						<div class="text">
							<textarea name="comment" rows="4"><?php if(isset($_POST['submit'])) { echo $_POST['comment']; } ?></textarea>
						</div>
					</div>
					<table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td class="boldText">
									Name
								</td>
								<td>
									<input name="name" id="name" type="text" class="medium" value="<?php if(isset($_POST['submit'])) { echo $_POST['name']; } ?>" />
								</td>
								<td class="boldText">
									Category
								</td>
								<td>
									<select name="category">
										<?php
											// Include the category selector menu.
											include('include/include_component_add_category_menu.php');
											$MenuCat = new AddMenuCat;
											$MenuCat->MenuCat();
										?>
									</select>
								</td>
								<td class="boldText">
									Quantity
								</td>
								<td>
									<input name="quantity" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['quantity']; } ?>" />
								</td>
							</tr>
							<tr>
								<td class="boldText">
									Manufacturer
								</td>
								<td>
									<input name="manufacturer" id="manufacturer" class="medium" type="text" value="<?php if(isset($_POST['submit'])) { echo $_POST['manufacturer']; } ?>" />
								</td>
								<td class="boldText">
									Package
								</td>
								<td>
									<input name="package" id="package" class="medium" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['package']; } ?>" />
								</td>
								<td class="boldText">
									Pins
								</td>
								<td>
									<input name="pins" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['pins']; } ?>" />
								</td>
							</tr>
							<tr>
								<td class="boldText">
									Location
								</td>
								<td>
									<input name="location" id="location" class="medium" type="text" value="<?php if(isset($_POST['submit'])) { echo $_POST['location']; } ?>" />
								</td>
								<td class="boldText">
									Price
								</td>
								<td>
									<input name="price" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['price']; } ?>" /> <?php echo $personal['currency']; ?>
								</td>
								<td class="boldText">
									To order
								</td>
								<td>
									<input name="orderquant" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['orderquant']; } ?>" />
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
										if(isset($_POST['submit']) && $_POST['smd'] == 'Yes'){
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
										if(isset($_POST['submit']) && $_POST['scrap'] == 'Yes'){
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
										if(isset($_POST['submit']) && $_POST['public'] == 'No'){
											echo '<input type="radio" name="public" value="Yes" /> Yes ';
											echo '<input type="radio" name="public" value="No" checked="checked"  /> No';
										}
										else{
											echo '<input type="radio" name="public" value="Yes" checked="checked" /> Yes ';
											echo '<input type="radio" name="public" value="No" /> No';
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
									<input name="weight" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['weight']; } ?>" /> <?php if($personal['measurement'] == 1){echo 'g';} else {echo 'g'; } ?>
								</td>
								<td class="boldText">
									Width
								</td>
								<td>
									<input name="width" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['width']; } ?>" /> <?php if($personal['measurement'] == 1){echo 'mm';} else {echo 'in'; } ?>
								</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td class="boldText">
									Depth
								</td>
								<td>
									<input name="depth" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['depth']; } ?>" /> <?php if($personal['measurement'] == 1){echo 'mm';} else {echo 'in'; } ?>
								</td>
								<td><img class="packageImage" border="0" src="img/boxSize.png"/></td>
								<td></td>
							</tr>
							<tr>
								<td class="boldText">
									Datasheet URL
								</td>
								<td>
									<input name="datasheet" type="text" class="medium" value="<?php if(isset($_POST['submit'])) { echo $_POST['datasheet']; } ?>" /> 
								</td>
								<td class="boldText">
									Height
								</td>
								<td>
									<input name="height" type="text" class="small" value="<?php if(isset($_POST['submit'])) { echo $_POST['height']; } ?>" /> <?php if($personal['measurement'] == 1){echo 'mm';} else {echo 'in'; } ?>
								</td>
								<td></td>
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
									<input name="url1" type="text" class="medium" value="<?php if(isset($_POST['submit'])) { echo $_POST['url1']; } ?>" />
								</td>
								<td class="boldText">
									Image URL 2
								</td>
								<td>
									<input name="url2" type="text" class="medium" value="<?php if(isset($_POST['submit'])) { echo $_POST['url2']; } ?>"  />
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
									<input name="url3" type="text" class="medium" value="<?php if(isset($_POST['submit'])) { echo $_POST['url3']; } ?>" />
								</td>
								<td class="boldText">
									Image URL 4
								</td>
								<td>
									<input name="url4" type="text" class="medium" value="<?php if(isset($_POST['submit'])) { echo $_POST['url4']; } ?>" />
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