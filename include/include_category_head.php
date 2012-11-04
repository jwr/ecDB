<?php
class NameHead {

	public function Head() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
		if(isset($_GET['subcat'])) {
			$headcat = (int)$_GET['subcat'];

			if ($headcat < 999) {
				$cat = substr($headcat, -3, 1);
			}
			else {
				$cat = substr($headcat, -4, 2);
			}
		}

		$CategoryName = "SELECT * FROM category_head ORDER by name ASC";
		$sql_exec_catname = mysql_Query($CategoryName);

		echo '<li>';
		echo '<a href=".';
		echo '">';
		echo "All";
		echo '</a></li> ';

		while ($ShowDetailsCatname = mysql_fetch_array($sql_exec_catname)) {
			echo '<li>';
			echo '<a href="category.php?cat=';
			echo $ShowDetailsCatname['id'];
			echo '" ';
			
			if(isset($_GET['cat'])) {
				$cat = (int)$_GET['cat'];
				if ($ShowDetailsCatname['id'] == $cat) {
					echo 'class="selected"';
				}
			}			
			echo '>';
			echo $ShowDetailsCatname['name'];
			echo '</a></li> ';
		}
	}
}
?>