<div id="header">
	
	<div class="logoWrapper">
		<a href ="."><span class="logoImage"></span></a>
	</div>
	
	<span class="userInfo">
		Logged in as <a href="my.php">
		<?php
			require_once('include/login/auth.php');
			include('include/mysql_connect.php');
			
			$owner = $_SESSION['SESS_MEMBER_ID'];
			$GetName = mysql_query("SELECT firstname, lastname FROM members WHERE member_id = ".$owner."");
			$headername = mysql_fetch_assoc($GetName);
			
			if(isset($_POST['submit']) && $_SERVER["REQUEST_URI"] == '/ecdb/my.php') { echo $_POST['firstname']; } else { echo $headername['firstname']; }
			echo ' ';
			if(isset($_POST['submit']) && $_SERVER["REQUEST_URI"] == '/ecdb/my.php') { echo $_POST['lastname']; } else { echo $headername['lastname']; }
		?>
		</a> - <a href="logout.php"> Sign out</a>
	</span>
	
	<div class="searchContent">
		<form class="search" action="search.php" method="get">
			<input type="text" name="q" />
		</form>
	</div>
</div>

