<?php
class ProjectShow {	
	public function ProjectShowComponents() {

		require_once('login/auth.php');
		include('mysql_connect.php');
		
		$owner = $_SESSION['SESS_MEMBER_ID'];
		$project_id = (int)mysql_real_escape_string($_GET["proj_id"]);
		
		
		if(isset($_GET['by'])) {
		
			$by			=	strip_tags(mysql_real_escape_string($_GET["by"]));
			$order_q	=	strip_tags(mysql_real_escape_string($_GET["order"]));
			
			if($order_q == 'desc' or $order_q == 'asc'){
				$order = $order_q;
			}
			else{
				$order = 'asc';
			}
			
			if($by == 'price' or $by == 'quantity') {
				$GetDataComponentsAll = "SELECT * FROM projects_data, data WHERE owner = ".$owner." AND projects_data.projects_data_component_id = data.id AND projects_data.projects_data_project_id = ".$project_id." ORDER by ".$by." +0 ".$order."";
			}
			elseif($by == 'name' or $by == 'category' or $by == 'manufacturer' or $by =='package' or $by =='smd') {
				$GetDataComponentsAll = "SELECT * FROM projects_data, data WHERE owner = ".$owner." AND projects_data.projects_data_component_id = data.id AND projects_data.projects_data_project_id = ".$project_id." ORDER by ".$by." ".$order."";
			}
			else {
				$GetDataComponentsAll = "SELECT * FROM projects_data, data WHERE owner = ".$owner." AND projects_data.projects_data_component_id = data.id AND projects_data.projects_data_project_id = ".$project_id." ORDER by name ASC";
			}
		}
		else {
			$GetDataComponentsAll = "SELECT * FROM projects_data, data WHERE owner = ".$owner." AND projects_data.projects_data_component_id = data.id AND projects_data.projects_data_project_id = ".$project_id." ORDER by name ASC";
		}
		
		$sql_exec = mysql_Query($GetDataComponentsAll);
		while($showDetails = mysql_fetch_array($sql_exec)) {
			echo "<tr>";

			echo '<td class="edit"><a href="edit_component.php?edit=';
			echo $showDetails['id'];
			echo '"><span class="icon medium pencil"></span></a></td>';

			echo '<td><a href="component.php?view=';
			echo $showDetails['id'];
			echo '">';

			echo $showDetails['name'];
			echo "</a></td>";

			echo "<td>";
			
				if ($showDetails['category'] < 999) {
					$head_cat_id = substr($showDetails['category'], -3, 1);
				}
				else {
					$head_cat_id = substr($showDetails['category'], -4, 2);
				}
				$subcatid = $showDetails['category'];
				
				$CategoryName = "SELECT * FROM category_head WHERE id = ".$head_cat_id."";
				$sql_exec_catname = mysql_Query($CategoryName);
			
				while($showDetailsCat = mysql_fetch_array($sql_exec_catname)) {
					$catname = $showDetailsCat['name'];
				}
				
			echo $catname;
			echo "</td>";

			echo "<td>";
			$manufacturer = $showDetails['manufacturer'];
				if ($manufacturer == ""){
					echo "-";
				}
				else{
					echo $manufacturer;
				}
			echo "</td>";

			echo "<td>";
			$package = $showDetails['package'];
				if ($package == ""){
					echo "-";
				}
				else{
					echo $package;
				}
			echo "</td>";

			echo "<td>";
			$smd = $showDetails['smd'];
				if ($smd == "No"){
					echo '<span class="icon medium checkboxUnchecked"></span>';
				}
				else{
					echo '<span class="icon medium checkboxChecked"></span>';
				}
			echo "</td>";

			echo "<td>";
			$price = $showDetails['price'];
				if ($price == ""){
					echo "-";
				}
				else{
					echo $price;
				}
			echo "</td>";

			echo "<td>";
			$quantity = $showDetails['quantity'];
				if ($quantity == ""){
					echo "-";
				}
				else{
					echo $quantity;
				}
			echo "</td>";
			
			echo "<td>";
			
			$comp_id = $showDetails['id'];
			$ShowQuant = mysql_query("SELECT projects_data_quantity FROM projects_data WHERE projects_data_component_id = '$comp_id' AND projects_data_project_id = '$project_id'");
			$quant = mysql_fetch_assoc($ShowQuant);
	
			$quantity = $quant['projects_data_quantity'];
				if ($quantity == ""){
					echo "-";
				}
				else{
					echo $quantity;
				}
				
				
			echo "</td>";

			echo "</tr>";
		}
	}
}
?>
