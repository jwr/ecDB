<?php
class Log {
  public function Log() {
	
		require_once('login/auth.php');
		include('mysql_connect.php');
		
		$owner = $_SESSION['SESS_MEMBER_ID'];
		$id 	= 	(int)$_GET['component'];
		
		$result = mysql_Query("SELECT * FROM log_data WHERE owner = ".$owner." AND comp_id = ".$id.""); 
		$before_quantity = 0;

		while($row = mysql_fetch_array($result)) {
			echo "<tr><td>";

			echo $row['date'];
			echo "</td>";

			echo "<td>";
			if($row['log_code'] == 1){
			echo "Created the component";
			}
			if($row['log_code'] == 2){
			echo "restocked the component";
			}
			echo "</td>";

			echo "<td>";
			echo $row['quantity'];
			echo "</td>";
			
			echo "<td>";
			echo - $before_quantity + $row['quantity'];
			echo "</td>";
			
			$before_quantity = $row['quantity'];
			
			echo "</tr>";
		}
	}
}
?>
