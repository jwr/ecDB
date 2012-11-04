<?php
class AddMenuProj {
	public function MenuProj() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
		$owner	=	$_SESSION['SESS_MEMBER_ID'];
		$id 	= 	(int)$_GET['edit'];
		
		$ProjectNameQuery = "SELECT * FROM projects WHERE project_owner = ".$owner." ORDER by project_name ASC";
		$sql_exec_projname = mysql_Query($ProjectNameQuery);
		
		$CategoryName = "SELECT * FROM projects_data WHERE component_id = ".$id." AND owner_id = ".$owner."";
		$sql_exec_catname = mysql_Query($CategoryName);
		
		while ($Project = mysql_fetch_array($sql_exec_projname)) {
			echo '<option ';

			while($showDetailsCat = mysql_fetch_array($sql_exec_catname)) {
				$projid = $showDetailsCat['project_id'];
			}
			
			if (isset($projid)) {
				if($projid == $Project['project_id']){
					echo 'selected ';
				}
			}

			echo 'value="';
			echo $Project['project_id'];
			echo '">';
			echo $Project['project_name'];
			echo '</option>';
		}
	}
}	
?>