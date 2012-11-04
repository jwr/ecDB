<?php
class ProjAdd {
	public function AddProj	() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
		if(isset($_POST['submit'])) {
			$owner			=	$_SESSION['SESS_MEMBER_ID'];
			$name 			= 	mysql_real_escape_string($_POST['name']);		

			if ($name == '') {
				echo '<div class="message red">';
				echo 'You have to specify a name!';
				echo '</div>';
			}
			else {
				$sql="INSERT into projects (project_owner, project_name) VALUES ('$owner', '$name')";
				$sql_exec = mysql_query($sql);
				
				$proj_id = mysql_insert_id();
				
				echo '<div class="message green center">';
				echo 'Project added!';
				echo '</div>';
			}
		}
	}
}
?>