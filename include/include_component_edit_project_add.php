<?php
class AddMenuProj {
	public function MenuProj() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');
		
		$owner	=	$_SESSION['SESS_MEMBER_ID'];
		$id		= 	(int)$_GET['edit'];
		
		echo '<option class="main_category" value="">';
		echo ' - Project - ';
		echo '</option>';
		
		$GetDataProject = "SELECT * FROM projects WHERE project_owner = '$owner'";
		$sql = mysql_query($GetDataProject);
		
		while($row1 = mysql_fetch_array($sql)){
		
			$query1 = "SELECT projects_data.projects_data_project_id, projects_data.projects_data_component_id FROM projects_data RIGHT JOIN projects ON projects.project_id = projects_data.projects_data_project_id WHERE projects.project_owner = '$owner'";
	 
			$result1 = mysql_query($query1);
			
			echo '<option value="';
			echo $row1['project_id'];
			echo '"';
			
			while($row2 = mysql_fetch_array($result1)){
				if ($row2['projects_data_component_id'] == $id && $row2['projects_data_project_id'] == $row1['project_id']){
					echo 'disabled="disabled"';
				}
				else {
					echo '';
				}
			}
			
			if(isset($_POST['submit'])) {
				if(isset($_POST['project'])) {
					if($row1['project_id'] == $_POST['project']) {
						echo ' selected ';
					}
				}
			}
			echo '>';
			echo $row1['project_name'];
			echo '</option>';
		}
	}
}	
?>