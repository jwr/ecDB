<?php
class AddMenuProj {
	public function MenuProj() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
		$owner	=	$_SESSION['SESS_MEMBER_ID'];
		
		$ProjectNameQuery = "SELECT * FROM projects WHERE project_owner = ".$owner." ORDER by project_name ASC";
		$sql_exec_projname = mysql_Query($ProjectNameQuery);

		echo '<option class="main_category" value="">';
		echo ' - Project - ';
		echo '</option>';
		
		while ($Project = mysql_fetch_array($sql_exec_projname)) {
			echo '<option value="';
			echo $Project['project_id'];
			echo '"';
			if(isset($_POST['submit'])) {
				if(isset($_POST['project'])) {
					if($Project['project_id'] == $_POST['project']) {
						echo ' selected ';
					}
				}
			}
			echo '>';
			echo $Project['project_name'];
			echo '</option>';
		}
	}
}	
?>