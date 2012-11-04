<?php
class ProjectShowComponents {	
	public function ProjectShowComponents() {

		require_once('login/auth.php');
		include('mysql_connect.php');
		
		$owner = $_SESSION['SESS_MEMBER_ID'];
		
		
		if(isset($_GET['proj_id'])) {
		
			$proj_id = mysql_real_escape_string((int)$_GET['proj_id']);
			
			$GetComponentIDs = "SELECT component_id FROM projects_data WHERE owner = ".$owner." AND project_id = ".$proj_id." ORDER by name ASC";
			$sql_exec_GetComponentIDs = mysql_Query($GetComponentIDs);
			
			while($showDetails_ComponentIDs = mysql_fetch_array($sql_exec_GetComponentIDs)) {
			
				$ComponentID = $showDetails_ComponentIDs['component_id'];
			}
		
		
			if(isset($_GET['by'])) {
			
				$by = $_GET["by"];
				$order = $_GET["order"];
				
				$bysql = mysql_real_escape_string($by);
				$ordersql = mysql_real_escape_string($order);
				
				if($by == 'price' or $by == 'pins' or $by == 'quantity') {
				
					$GetDataComponentsAll = "SELECT * FROM data WHERE owner = ".$owner." ORDER by ".$bysql." +0 ".$ordersql."";
				}
				else {
				
					$GetDataComponentsAll = "SELECT * FROM data WHERE owner = ".$owner." ORDER by ".$bysql." ".$ordersql."";
				}
			}
			else {
				$GetDataComponentsAll = "SELECT * FROM data WHERE owner = ".$owner." ORDER by name ASC";
			}
			
			
			$sql_exec = mysql_Query($GetDataComponentsAll);
			while($showDetails = mysql_fetch_array($sql_exec)) {
				echo "<tr>";

				echo '<td class="edit"><a href="edit_component.php?edit=';
				echo $showDetails['id'];
				echo '"><img src="img/pencil-small.png" alt="Edit"/></a></td>';

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
				$pins = $showDetails['pins'];
					if ($pins == ""){
						echo "-";
					}
					else{
						echo $pins;
					}
				echo "</td>";

				echo '<td>';
				$image = $showDetails['url1'];
				if ($image==""){
					echo "-";
				}
				else{
					echo '<a class="thumbnail" href="';
					echo $image;
					echo '"><img src="img/image.png" border="0" /><span><img src="';
					echo $image;
					echo '" width="250" /></span></a>';
				}

				echo '<td>';
				$datasheet = $showDetails['datasheet'];
				if ($datasheet==""){
					echo "-";
				}
				else{
					echo '<a href="';
					echo $datasheet;
					echo '"  target="_blank"><img src="img/document-pdf-text.png" alt="Download PDF" /></a></td>';
				}

				echo "<td>";
				$smd = $showDetails['smd'];
					if ($smd == "No"){
						echo '<img src="img/no.png">';
					}
					else{
						echo '<img src="img/yes.png">';
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

				$comment = $showDetails['comment'];
				if ($comment==""){
					echo '<td class="comment"><div>';
					echo "-";
					echo '</span></div></td>';
				}
				else{
					echo '<td class="comment"><div><img src="img/infocard.png" alt="Comment"/><span>';
					echo $showDetails['comment'];
					echo '</span></div></td>';
				}
				echo "</tr>";
			}
		}
	}
}
?>