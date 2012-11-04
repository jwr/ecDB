<?php
class ProjAdd {
	public function AddProj	() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
		if(isset($_POST['submit'])) {
			$owner			=	$_SESSION['SESS_MEMBER_ID'];
			$name 			= 	mysql_real_escape_string($_POST['name']);
			$id 			= 	(int)$_GET['proj_id'];
			
			if ($name == '') {
				echo 'You have to specify a name!';
			}
			else {
				$sql = "UPDATE projects SET project_name = '".$name."' WHERE project_id = ".$id." ";
				$sql_exec = mysql_query($sql);

				header("location: " . $_SERVER['REQUEST_URI']);
			}
		}
	}
}
?>