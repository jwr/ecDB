<?php
class AddMenuCat {
	public function MenuCat() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
		$HeadCategoryNameQuery = "SELECT * FROM category_head ORDER by name ASC";
		$sql_exec_headcat = mysqli_query($link,$HeadCategoryNameQuery);

		echo '<option class="main_category" value="">';
		echo ' - Category - ';
		echo '</option>';
		
		while ($HeadCategory = mysqli_fetch_array($sql_exec_headcat)) {
			echo '<option class="main_category" value="';
			echo $HeadCategory['id'];
			echo '" disabled="disabled">';
			echo $HeadCategory['name'];
			echo '</option>';
			
			$subcatfrom = $HeadCategory['id'] * 100;
			$subcatto = $subcatfrom + 99;
			
			$SubCategoryNameQuery = "SELECT * FROM category_sub WHERE id BETWEEN ".$subcatfrom." AND ".$subcatto." ORDER by name ASC";
			$sql_exec_subcat = mysqli_query($link,$SubCategoryNameQuery);
			
			while ($SubCategory = mysqli_fetch_array($sql_exec_subcat)) {
				echo '<option value="';
				echo $SubCategory['id'];
				echo '"';
				if(isset($_POST['submit'])) {
					if(isset($_POST['category'])) {
						if($SubCategory['id'] == $_POST['category']) {
							echo ' selected ';
						}
					}
				}
				echo '>';
				echo $SubCategory['name'];
				echo '</option>';
			}
		}
	}
}	
?>
