<?php
class NameSub {

	public function Sub() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		$owner = $_SESSION['SESS_MEMBER_ID'];

		if(isset($_GET['cat'])) {
			$cat = (int)$_GET['cat'];
		}
		if(isset($_GET['subcat'])) {
			$subcat = (int)$_GET['subcat'];

			if ($subcat < 999) {
				$cat = substr($subcat, -3, 1);
			}
			else {
				$cat = substr($subcat, -4, 2);
			}
		}

		$subcatfrom = $cat*100;
		$subcatto = $subcatfrom+99;

		$SubCategoryName = "SELECT * FROM category_sub WHERE id BETWEEN ".$subcatfrom." AND ".$subcatto." ORDER by name ASC";
		$sql_exec_subcatname = mysql_Query($SubCategoryName);

		while ($ShowDetailsSubCatname = mysql_fetch_array($sql_exec_subcatname)) {
			echo '<li>';
			echo '<a href="category.php?subcat=';
			echo $ShowDetailsSubCatname['id'];
			echo '" ';
			if(isset($_GET['subcat'])) {
				if ($ShowDetailsSubCatname['id'] == $subcat) {
					echo 'class="selected"';
				}
			}

			// Shows if component exists in category
			$sql_exec_component_catname = mysql_query("SELECT category FROM data WHERE owner = $owner"); // Get the category ID from all components.
			while($showDetailsComponentCatname = mysql_fetch_array($sql_exec_component_catname)) {
				if($showDetailsComponentCatname['category'] == $ShowDetailsSubCatname['id']){ // Compare current category ID with components category ID.
					echo ' class="isComponents"'; // What should be echoed if components exists in category?
					break; // We only need one component to be in this category for this to be true.
				}
			}

			echo '>';
				echo $ShowDetailsSubCatname['name'];
			echo '</a></li> ';
		}
	}
}
?>