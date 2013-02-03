<?php
class ShowComponents {
	public function Index() {

		require_once('login/auth.php');
		include('mysql_connect.php');

		$owner = $_SESSION['SESS_MEMBER_ID'];

		if(isset($_GET['by'])) {

			$by			=	strip_tags(mysql_real_escape_string($_GET["by"]));
			$order_q	=	strip_tags(mysql_real_escape_string($_GET["order"]));

			if($order_q == 'desc' or $order_q == 'asc'){
				$order = $order_q;
			}
			else{
				$order = 'asc';
			}

			if($by == 'price' or $by == 'pins' or $by == 'quantity') {
				$GetDataComponentsAll = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE owner = ".$owner." ORDER by ".$by." +0 ".$order."";
			}
			elseif($by == 'name' or $by == 'category' or $by =='package' or $by =='smd') {
				$GetDataComponentsAll = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE owner = ".$owner." ORDER by ".$by." ".$order."";
			}
			else {
				$GetDataComponentsAll = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE owner = ".$owner." ORDER by name ASC";
			}
		}
		else {
			$GetDataComponentsAll = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE owner = ".$owner." ORDER by name ASC";
		}


		$sql_exec = mysql_Query($GetDataComponentsAll);
		while($showDetails = mysql_fetch_array($sql_exec)) {
			echo "<tr>";

			echo '<td class="edit"><a href="edit_component.php?edit=';
			echo $showDetails['id'];
			echo '"><span class="icon medium pencil"></span></a></td>';

			echo '<td><a href="component.php?view=';
			echo $showDetails['id'];
			echo '">';

			echo $showDetails['name'];
			echo "</a></td>";

			echo "<td>";

				if ($showDetails['category'] < 999) {
					$head_cat_id = substr($showDetails['category'], -3, 1);
				}
				else {
					$head_cat_id = substr($showDetails['category'], -4, 2);
				}
				$subcatid = $showDetails['category'];

				$CategoryName = "SELECT * FROM category_head WHERE id = ".$head_cat_id."";
				$sql_exec_catname = mysql_Query($CategoryName);

				while($showDetailsCat = mysql_fetch_array($sql_exec_catname)) {
					$catname = $showDetailsCat['name'];
				}

			echo "<a href='category.php?cat=$head_cat_id'>$catname</a>";
			echo "</td>";

			echo "<td>";
			$package = $showDetails['package'];
				if ($package == ""){
					echo "-";
				}
				else{
					echo $package;
				}
			echo "</td>";

			echo "<td>";
			$pins = $showDetails['pins'];
				if ($pins == ""){
					echo "-";
				}
				else{
					echo $pins;
				}
			echo "</td>";

			echo '<td>';
			$image = $showDetails['url1'];
			if ($image==""){
				echo "-";
			}

			else{
				echo '<a class="thumbnail" href="';
				echo $image;
				echo '"><span class="icon medium picture"></span><span class="imgB"><img src="';
				echo $image;
				echo '" /></span></a></td>';
			}

			echo '<td>';
			$datasheet = $showDetails['datasheet'];
			if ($datasheet==""){
				echo "-";
			}

			else{
				echo '<a href="';
				echo $datasheet;
				echo '"  target="_blank"><span class="icon medium document"></span></a></td>';
			}

			echo "<td>";
			$smd = $showDetails['smd'];
				if ($smd == "No"){
					echo '<span class="icon medium checkboxUnchecked"></span>';
				}
				else{
					echo '<span class="icon medium checkboxChecked"></span>';
				}
			echo "</td>";

			echo "<td>";
			$price = $showDetails['price'];
				if ($price == ""){
					echo "-";
				}
				else{
					echo $price;
				}
			echo "</td>";

			echo "<td>";
			$quantity = $showDetails['quantity'];
				if ($quantity == ""){
					echo "-";
				}
				else{
					echo $quantity;
				}
			echo "</td>";

			$comment = $showDetails['comment'];
			if ($comment==""){
				echo '<td class="comment"><div>';
				echo "-";
				echo '</span></div></td>';
			}
			else{
				echo '<td class="comment"><div><span class="icon medium spechBubbleSq"></span><span class="comment">';
				echo nl2br($showDetails['comment']);
				echo '</span></div></td>';
			}
			echo "</tr>";
		}
	}
	public function Category() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');

		$owner = $_SESSION['SESS_MEMBER_ID'];

		if(isset($_GET['cat'])) {

			$cat = (int)$_GET['cat'];
			$subcatfrom = $cat*100;
			$subcatto = $subcatfrom+99;


			$CategoryName = "SELECT * FROM category_sub WHERE id = ".$cat."";
			$sql_exec_catname = mysql_Query($CategoryName);

			if(isset($_GET['by'])) {

				$by			=	strip_tags(mysql_real_escape_string($_GET["by"]));
				$order_q	=	strip_tags(mysql_real_escape_string($_GET["order"]));

				if($order_q == 'desc' or $order_q == 'asc') {
					$order = $order_q;
				}
				else {
					$order = 'asc';
				}

				if($by == 'price' or $by == 'pins' or $by == 'quantity') {
					$ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." ORDER by ".$by." +0 ".$order."";
				}
				elseif($by == 'name' or $by == 'category' or $by =='package' or $by =='smd') {
					$ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." ORDER by ".$by." ".$order."";
				}
				else {
					$ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." ORDER by name ASC";
				}
			}
			else {
				$ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." ORDER by name ASC";
			}

			$sql_exec_component = mysql_Query($ComponentsCategory);

			while ($showDetails = mysql_fetch_array($sql_exec_component)) {
				echo "<tr>";

				echo '<td class="edit"><a href="edit_component.php?edit=';
				echo $showDetails['id'];
				echo '"><span class="icon medium pencil"></span></a></td>';

				echo '<td><a href="component.php?view=';
				echo $showDetails['id'];
				echo '">';
				echo $showDetails['name'];
				echo "</a></td>";

				echo "<td>";
				$subcatid = $showDetails['category'];

				$CategoryName = "SELECT * FROM category_sub WHERE id = ".$subcatid."";
				$sql_exec_catname = mysql_Query($CategoryName);

				while($showDetailsCat = mysql_fetch_array($sql_exec_catname)) {
					$catname = $showDetailsCat['name'];
				}

				echo "<a href='category.php?subcat=$subcatid'>$catname</a>";
				echo "</td>";

				echo "<td>";
				$package = $showDetails['package'];
					if ($package == ""){
						echo "-";
					}
					else{
						echo $package;
					}
				echo "</td>";

				echo "<td>";
				$pins = $showDetails['pins'];
					if ($pins == ""){
						echo "-";
					}
					else{
						echo $pins;
					}
				echo "</td>";

				echo '<td>';
				$image = $showDetails['url1'];
				if ($image==""){
					echo "-";
				}
				else{
					echo '<a class="thumbnail" href="';
					echo $image;
					echo '"><span class="icon medium picture"></span><span class="imgB"><img src="';
					echo $image;
					echo '" /></span></a></td>';
				}

				echo '<td>';
				$datasheet = $showDetails['datasheet'];
				if ($datasheet==""){
					echo "-";
				}
				else{
					echo '<a href="';
					echo $datasheet;
					echo '" target="_blank"><span class="icon medium document"></span></a></td>';
				}

				echo "<td>";
				$smd = $showDetails['smd'];
					if ($smd == "No"){
						echo '<span class="icon medium checkboxUnchecked"></span>';
					}
					else{
						echo '<span class="icon medium checkboxChecked"></span>';
					}
				echo "</td>";

				echo "<td>";
				$price = $showDetails['price'];
					if ($price == ""){
						echo "-";
					}
					else{
						echo $price;
					}
				echo "</td>";

				echo "<td>";
				$quantity = $showDetails['quantity'];
					if ($quantity == ""){
						echo "-";
					}
					else{
						echo $quantity;
					}
				echo "</td>";

				$comment = $showDetails['comment'];
				if ($comment == ""){
					echo '<td class="comment"><div>';
					echo "-";
					echo '</span></div></td>';
				}
				else{
					echo '<td class="comment"><div><span class="icon medium spechBubbleSq"></span><span class="comment">';
					echo $showDetails['comment'];
					echo '</span></div></td>';
				}
				echo "</tr>";
			}
		}


		if(isset($_GET['subcat'])) {

			$subcat = (int)$_GET['subcat'];

			$CategoryName = "SELECT * FROM category_sub WHERE id = ".$subcat."";
			$sql_exec_catname = mysql_Query($CategoryName);

			if(isset($_GET['by'])) {

				$by			=	strip_tags(mysql_real_escape_string($_GET["by"]));
				$order_q	=	strip_tags(mysql_real_escape_string($_GET["order"]));

				if($order_q == 'desc' or $order_q == 'asc') {
					$order = $order_q;
				}
				else {
					$order = 'asc';
				}

				if($by == 'price' or $by == 'pins' or $by == 'quantity') {
					$ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner." ORDER by ".$by." +0 ".$order."";
				}
				elseif($by == 'name' or $by == 'category' or $by =='package' or $by =='smd') {
					$ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner." ORDER by ".$by." ".$order."";
				}
				else {
					$ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner." ORDER by name ASC";
				}
			}
			else{
				$ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, url1, smd, price, quantity, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner." ORDER by name ASC";
			}

			$sql_exec_component = mysql_Query($ComponentsCategory);

			while ($showDetails = mysql_fetch_array($sql_exec_component)) {
				echo "<tr>";

				echo '<td class="edit"><a href="edit_component.php?edit=';
				echo $showDetails['id'];
				echo '"><img src="img/pencil.png" alt="Edit"/></a></td>';

				echo '<td><a href="component.php?view=';
				echo $showDetails['id'];
				echo '">';
				echo $showDetails['name'];
				echo "</a></td>";

				echo "<td>";
					while($showDetailsCat = mysql_fetch_array($sql_exec_catname)) {
						$catname = $showDetailsCat['name'];
					}
					echo $catname;
				echo "</td>";

				echo "<td>";
				$package = $showDetails['package'];
					if ($package == ""){
						echo "-";
					}
					else{
						echo $package;
					}
				echo "</td>";

				echo "<td>";
				$pins = $showDetails['pins'];
					if ($pins == ""){
						echo "-";
					}
					else{
						echo $pins;
					}
				echo "</td>";

				echo '<td>';
				$image = $showDetails['url1'];
				if ($image==""){
					echo "-";
				}
				else{
					echo '<a class="thumbnail" href="';
					echo $image;
					echo '"><img src="img/picture.png" /><span class="imgB"><img src="';
					echo $image;
					echo '" /></span></a></td>';
				}

				echo '<td>';
				$datasheet = $showDetails['datasheet'];
				if ($datasheet==""){
					echo "-";
				}
				else{
					echo '<a href="';
					echo $datasheet;
					echo '" target="_blank"><img src="img/document.png" alt="Download PDF"/></a></td>';
				}

				echo "<td>";
				$smd = $showDetails['smd'];
					if ($smd == "No"){
						echo '<img src="img/checkbox_unchecked.png">';
					}
					else{
						echo '<img src="img/checkbox_checked.png">';
					}
				echo "</td>";

				echo "<td>";
				$price = $showDetails['price'];
					if ($price == ""){
						echo "-";
					}
					else{
						echo $price;
					}
				echo "</td>";

				echo "<td>";
				$quantity = $showDetails['quantity'];
					if ($quantity == ""){
						echo "-";
					}
					else{
						echo $quantity;
					}
				echo "</td>";

				$comment = $showDetails['comment'];
				if ($comment == ""){
					echo '<td class="comment"><div>';
					echo "-";
					echo '</span></div></td>';
				}
				else{
					echo '<td class="comment"><div><span class="icon medium spechBubbleSq"></span><span class="comment">';
					echo $showDetails['comment'];
					echo '</span></div></td>';
				}
				echo "</tr>";
			}
		}
	}
	public function Search() {

		if(isset($_GET['q'])) {

			require_once('include/login/auth.php');
			include('include/mysql_connect.php');

			$owner = $_SESSION['SESS_MEMBER_ID'];

			$query = mysql_real_escape_string($_GET['q']);

			$query1 = strtoupper($query);
			$query2 = strip_tags($query1);
			$find = trim($query2);


			if ($find == "") {
				echo '<div class="message red">';
					echo "You forgot to enter a search term.";
				echo '</div>';
			}
			else {


				if (isset($_GET['by'])){
					$by			=	strip_tags(mysql_real_escape_string($_GET["by"]));
					$order_q	=	strip_tags(mysql_real_escape_string($_GET["order"]));

					if($order_q == 'desc' or $order_q == 'asc'){
						$order = $order_q;
					}
					else{
						$order = 'asc';
					}

					if($by == 'price' or $by == 'pins' or $by == 'quantity') {
						$SearchQuery = "SELECT * FROM data WHERE (name LIKE'%$find%' OR package LIKE'%$find%' OR manufacturer LIKE'%$find%' OR pins LIKE'%$find%' OR location LIKE'%$find%' OR comment LIKE'%$find%') AND owner = $owner ORDER by $by +0 $order";
					}
					elseif($by == 'name' or $by == 'category' or $by =='package' or $by =='smd' or $by =='manufacturer') {
						$SearchQuery = "SELECT * FROM data WHERE (name LIKE'%$find%' OR package LIKE'%$find%' OR manufacturer LIKE'%$find%' OR pins LIKE'%$find%' OR location LIKE'%$find%' OR comment LIKE'%$find%') AND owner = $owner ORDER by $by $order";
					}
					else {
						$SearchQuery = "SELECT * FROM data WHERE (name LIKE'%$find%' OR package LIKE'%$find%' OR manufacturer LIKE'%$find%' OR pins LIKE'%$find%' OR location LIKE'%$find%' OR comment LIKE'%$find%') AND owner = $owner ORDER by name ASC";
					}
				}
				else{
					$SearchQuery = "SELECT * FROM data WHERE (name LIKE'%$find%' OR package LIKE'%$find%' OR manufacturer LIKE'%$find%' OR pins LIKE'%$find%' OR location LIKE'%$find%' OR comment LIKE'%$find%') AND owner = $owner ORDER by name ASC";
				}

				$sql_exec = mysql_query($SearchQuery);
				$anymatches = mysql_num_rows($sql_exec);
				if ($anymatches == 0) {
					echo '<div class="message red">';
						echo "Sorry, but we can not find an entry to match your query.";
					echo '</div>';
				}

				while($showDetails = mysql_fetch_array($sql_exec)) {
					echo "<tr>";

					echo '<td class="edit"><a href="edit_component.php?edit=';
					echo $showDetails['id'];
					echo '"><img src="img/pencil.png" alt="Edit"/></a></td>';

					echo '<td><a href="component.php?view=';
					echo $showDetails['id'];
					echo '">';

					echo $showDetails['name'];
					echo "</a></td>";

					echo "<td>";
						if ($showDetails['category'] < 999) {
							$head_cat_id = substr($showDetails['category'], -3, 1);
						}
						else {
							$head_cat_id = substr($showDetails['category'], -4, 2);
						}
						$subcatid = $showDetails['category'];

						$CategoryName = "SELECT * FROM category_head WHERE id = ".$head_cat_id."";
						$sql_exec_catname = mysql_Query($CategoryName);

						while($showDetailsCat = mysql_fetch_array($sql_exec_catname)) {
							$catname = $showDetailsCat['name'];
						}

					echo $catname;
					echo "</td>";

					echo "<td>";
					$manufacturer = $showDetails['manufacturer'];
						if ($manufacturer == ""){
							echo "-";
						}
						else{
							echo $manufacturer;
						}
					echo "</td>";

					echo "<td>";
					$package = $showDetails['package'];
						if ($package == ""){
							echo "-";
						}
						else{
							echo $package;
						}
					echo "</td>";

					echo "<td>";
					$pins = $showDetails['pins'];
						if ($pins == ""){
							echo "-";
						}
						else{
							echo $pins;
						}
					echo "</td>";

					echo '<td>';
					$image = $showDetails['url1'];
					if ($image==""){
						echo "-";
					}

					else{
						echo '<a class="thumbnail" href="';
						echo $image;
						echo '"><span class="icon medium picture"></span><span class="imgB"><img src="';
						echo $image;
						echo '" /></span></a></td>';
					}

					echo '<td>';
					$datasheet = $showDetails['datasheet'];
					if ($datasheet==""){
						echo "-";
					}
					else{
						echo '<a href="';
						echo $datasheet;
						echo ' target="_blank""><span class="icon medium document"></span></a></td>';
					}

					echo "<td>";
					$smd = $showDetails['smd'];
						if ($smd == "No"){
							echo '<img src="img/checkbox_unchecked.png">';
						}
						else{
							echo '<img src="img/checkbox_checked.png">';
						}
					echo "</td>";

					echo "<td>";
					$price = $showDetails['price'];
						if ($price == ""){
							echo "-";
						}
						else{
							echo $price;
						}
					echo "</td>";

					echo "<td>";
					echo $showDetails['quantity'];
					echo "</td>";

					$comment = $showDetails['comment'];
					if ($comment == ""){
						echo '<td class="comment"><div>';
						echo "-";
						echo '</span></div></td>';
					}
					else{
						echo '<td class="comment"><div><span class="icon medium spechBubbleSq"></span><span class="comment">';
						echo $showDetails['comment'];
						echo '</span></div></td>';
					}
					echo "</tr>";
				}
			}
		}
	}
	public function Add() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');

		if(isset($_POST['submit']) or isset($_POST['update'])) {
			$owner				=	$_SESSION['SESS_MEMBER_ID'];

			if (empty($_GET['edit'])) {
				$id				=	'';
			}
			else{
				$id				= 	(int)$_GET['edit'];
			}

			if (empty($_POST['name'])) {
				$name = '';
			}
			else{
				$name			=	strip_tags(mysql_real_escape_string($_POST['name']));
			}

			if (empty($_POST['quantity'])) {
				$quantity = 0;
			}
			else{
				$quantity			=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['quantity'])));
			}

			if (empty($_POST['category'])) {
				$category = '';
			}
			else{
				$category		=	strip_tags(mysql_real_escape_string($_POST['category']));
			}

			if (empty($_POST['project'])) {
				$project = '';
			}
			else{
				$project		=	strip_tags(mysql_real_escape_string($_POST['project']));
			}

			$comment			=	strip_tags(mysql_real_escape_string($_POST['comment']));
			$order_quantity		=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['orderquant'])));
			$project_quantity	=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['projquant'])));
			$price				=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['price'])));
			$location			=	strip_tags(mysql_real_escape_string($_POST['location']));
			$manufacturer		=	strip_tags(mysql_real_escape_string($_POST['manufacturer']));
			$package			=	strip_tags(mysql_real_escape_string($_POST['package']));
			$pins				=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['pins'])));
			$scrap				=	strip_tags(mysql_real_escape_string($_POST['scrap']));
			$smd				=	strip_tags(mysql_real_escape_string($_POST['smd']));
			$public				=	strip_tags(mysql_real_escape_string($_POST['public']));
			$width				=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['width'])));
			$height				=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['height'])));
			$depth				=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['depth'])));
			$weight				=	str_replace(',', '.', strip_tags(mysql_real_escape_string($_POST['weight'])));
			$datasheet			=	strip_tags(mysql_real_escape_string($_POST['datasheet']));
			$url1				=	strip_tags(mysql_real_escape_string($_POST['url1']));
			$url2				=	strip_tags(mysql_real_escape_string($_POST['url2']));
			$url3				=	strip_tags(mysql_real_escape_string($_POST['url3']));
			$url4				=	strip_tags(mysql_real_escape_string($_POST['url4']));


			if ($name == '') {
				echo '<div class="message red">';
				echo 'You have to specify a name!';
				echo '</div>';
			}
			elseif ($category == '') {
				echo '<div class="message red">';
				echo 'You have to choose a category!';
				echo '</div>';
			}
			elseif (!empty($project_quantity) && empty($project)) {
				echo '<div class="message red">';
				echo 'You have to choose a project!';
				echo '</div>';
			}
			elseif (!empty($project) && empty($project_quantity)) {
				echo '<div class="message red">';
				echo 'You have to specify a quantity for this component to add to the project!';
				echo '</div>';
			}
			elseif (strlen($comment) >= 2500) {
				echo '<div class="message red">';
				echo 'Max 2500 characters in the comment!';
				echo '</div>';
			}
			elseif (!empty($_POST['quantity']) && !is_numeric($quantity)) {
				echo '<div class="message red">';
				echo 'The quantity must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['pins']) && !is_numeric($pins)) {
				echo '<div class="message red">';
				echo 'The pin-count must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['price']) && !is_numeric($price)) {
				echo '<div class="message red">';
				echo 'The price must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['orderquant']) && !is_numeric($order_quantity)) {
				echo '<div class="message red">';
				echo 'The order quantity must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['weight']) && !is_numeric($weight)) {
				echo '<div class="message red">';
				echo 'The weight must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['width']) && !is_numeric($width)) {
				echo '<div class="message red">';
				echo 'The width must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['depth']) && !is_numeric($depth)) {
				echo '<div class="message red">';
				echo 'The depth must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['height']) && !is_numeric($height)) {
				echo '<div class="message red">';
				echo 'The height must only be a number!';
				echo '</div>';
			}
			else {
				if(isset($_POST['submit'])) {
					$sql="INSERT into data (owner, name, manufacturer, package, pins, smd, quantity, location, scrap, width, height, depth, weight, datasheet, comment, category, url1, url2, url3, url4, price, public, order_quantity)
					VALUES
					('$owner', '$name', '$manufacturer', '$package', '$pins', '$smd', '$quantity', '$location', '$scrap', '$width', '$height', '$depth', '$weight', '$datasheet', '$comment', '$category', '$url1', '$url2', '$url3', '$url4', '$price', '$public', '$order_quantity')";

					$sql_exec = mysql_query($sql) or die(mysql_error());
					$component_id = mysql_insert_id();

					if (!empty($project) && !empty($project_quantity)) {
						$proj_add="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity)
							VALUES
							('$owner', '$project', '$component_id', '$project_quantity')";

						$sql_exec = mysql_query($proj_add);
					}

					/*------------------------------------------------------------------------------------------
					$proj =	$_POST['project'];

					foreach ($proj as $quantity){
						$project = array_search($quantity, $proj);
						//echo $quantity;	// Quantity
						//echo ' - ';
						//echo $project;	// Project ID.
						//echo ' <br />';
						if ($quantity == 0){
							echo 'None';
						}
						else{
							$proj_add="INSERT into projects_data (owner_id, project_id, component_id, quantity)
							VALUES
							('$owner', '$project', '$component_id', '$quantity')";

							$sql_exec = mysql_query($proj_add);

							echo 'Inserted';
						}
					}
					------------------------------------------------------------------------------------------*/

					echo '<div class="message green center">';
					echo 'Component added! - <a href="component.php?view=';
					echo $component_id;
					echo '">View component (';
						$result = mysql_query("SELECT name FROM data WHERE id = '$component_id'");
						$name = mysql_fetch_array($result);
						echo $name['name'];
					echo ')</a>';
					echo '</div>';
				}

				if(isset($_POST['update'])) {
					$sql = "UPDATE data SET
					name = '$name', manufacturer = '$manufacturer', package = '$package', pins = '$pins', smd = '$smd', quantity = '$quantity', location = '$location',	scrap = '$scrap', width = '$width', height = '$height', depth = '$depth', weight = '$weight', datasheet = '$datasheet', comment = '$comment', category = '$category', url1 = '$url1', url2 = '$url2',  url3 = '$url3', url4 = '$url4', price = '$price', public = '$public', order_quantity = '$order_quantity'	WHERE id = '$id'";

					$sql_exec = mysql_query($sql);

					if (!empty($project) && !empty($project_quantity)) {
						$proj_add="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity)
							VALUES
							('$owner', '$project', '$id', '$project_quantity')";

						$sql_exec = mysql_query($proj_add) or die(mysql_error());
						echo $project;
						echo ' Owner ';
						echo $owner;
						echo ' id ';
						echo $id;
						echo ' projquant ';
						echo $project_quantity;
					}

					if (isset($_POST['projquantedit'])) {
						$proj =	$_POST['projquantedit'];

						foreach ($proj as $quantity_proj_add){
							$projects = array_search($quantity_proj_add, $proj);
							$sqlDeleteProject = "DELETE FROM projects_data WHERE projects_data_component_id = '$id' AND projects_data_project_id = '$projects'";
							$sql_exec_project_delete = mysql_query($sqlDeleteProject);

							if ($quantity_proj_add == 0){
								echo 'None';
							}
							else{
								$proj_edit="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity)
								VALUES
								('$owner', '$projects', '$id', '$quantity_proj_add')";

								$sql_exec = mysql_query($proj_edit);

								/*
								echo 'Projid: ';
								echo $project;
								echo ' Quantity: ';
								echo $quantity;
								echo ' Id: ';
								echo $id;
								echo '<br>';
								*/
							}
						}
					}
					header("location: " . $_SERVER['REQUEST_URI']);
				}
			}
		}
	}
}
?>