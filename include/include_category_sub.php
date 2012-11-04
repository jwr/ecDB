<?php
class NameSub {

	public function Sub() {
		
		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
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
			echo '>';
			echo $ShowDetailsSubCatname['name'];
			echo '</a></li> ';
		}
	}
}
?>