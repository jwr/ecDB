<?php
class ShoplistPrice {
	public function ShoplistPriceSum() {
	
		require_once('login/auth.php');
		include('mysql_connect.php');

		$owner = $_SESSION['SESS_MEMBER_ID'];
		$GetPersonal = mysql_query("SELECT currency FROM members WHERE member_id = ".$owner."");
		$personal = mysql_fetch_assoc($GetPersonal);

		$GetDataComponentsAll = "SELECT price,order_quantity FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by name ASC";

		$sql_exec = mysql_Query($GetDataComponentsAll);
		while($showDetails = mysql_fetch_array($sql_exec)) {
	
			$price = $showDetails['price'];
			$quantity = $showDetails['order_quantity'];

			$product =  $price * $quantity;
			$sum[] = $product;
			
		}
		if (isset($sum)) {
			echo array_sum($sum);
			echo ' ';
			echo $personal['currency'];
		}
		else {
			echo '0';
			echo ' ';
			echo $personal['currency'];
		}
	}
}
?>