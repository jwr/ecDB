<?php
class Proj {
	public function ProjList() {

		// Funktion för att visa alla projekt, används i proj_list.php
	
		require_once('login/auth.php');
		include('mysql_connect.php');
		
		$owner = $_SESSION['SESS_MEMBER_ID'];
		
		$GetPersonal = mysql_query("SELECT currency FROM members WHERE member_id = ".$owner."");
		$personal = mysql_fetch_assoc($GetPersonal);

		if(isset($_GET['by'])) {
		
			$by			=	strip_tags(mysql_real_escape_string($_GET["by"]));
			$order_q	=	strip_tags(mysql_real_escape_string($_GET["order"]));
			
			if($order_q == 'desc' or $order_q == 'asc'){
				$order = $order_q;
			}
			else{
				$order = 'asc';
			}
			
			if($by == 'name') {
				$GetDataComponentsAll = "SELECT * FROM projects WHERE project_owner = ".$owner." ORDER by project_name ".$order."";
			}
			else {
				$GetDataComponentsAll = "SELECT * FROM projects WHERE project_owner = ".$owner." ORDER by project_name ASC";
			}
		}
		else {
			$GetDataComponentsAll = "SELECT * FROM projects WHERE project_owner = ".$owner." ORDER by project_name ASC";
		}
		
		$sql_exec = mysql_Query($GetDataComponentsAll);

		while($showDetails = mysql_fetch_array($sql_exec)) {
			echo "<tr>";
				echo '<td class="edit"><a href="proj_edit.php?proj_id=';
				echo $showDetails['project_id'];
				echo '"><span class="icon medium pencil"></span></a></td>';
	
				echo '<td>';
					echo '<a href="proj_show.php?proj_id=';
					echo $showDetails['project_id'];
					echo '">';
					echo $showDetails['project_name'];
					echo '</a>';
				echo '</td>';
				
				echo "<td>";
					$components = mysql_query("SELECT projects_data_project_id FROM projects_data WHERE projects_data_project_id = ".$showDetails['project_id']."");
					$number_components = mysql_num_rows($components);
					if ($number_components == 0){
						echo "-";
					}
					else{
						echo $number_components;
					}
				echo "</td>";
				
				echo '<td>';
					$GetDataPrice = "SELECT SUM(total) FROM (SELECT projects_data_quantity * price AS total FROM projects_data JOIN `data` WHERE data.id = projects_data_component_id AND projects_data_project_id = ".$showDetails['project_id'].") AS project_total";
					$sql_exec_price = mysql_Query($GetDataPrice) or die(mysql_error());
					
					while($showPrice = mysql_fetch_array($sql_exec_price)) {
						if ($showPrice['SUM(total)'] == 0){
							echo "-";
						}
						else{
							echo $showPrice['SUM(total)']; 
							echo ' ';
							echo $personal['currency'];
						}
					}
				echo '</td>';
			echo "</tr>";
		}
	}
}
?>
