<div id="menu">
	<ul>
		<li><a href="." class="<?php if ($_SERVER["REQUEST_URI"] == '/' or $_SERVER["REQUEST_URI"] == '/index.php'or isset($_GET['view']) or isset($_GET['cat'])or isset($_GET['subcat']) or isset($_GET['edit']) or isset($_GET['based'])){echo 'selected';}?>">My components</a></li>
		<li><a href="add.php" class="<?php if ($_SERVER["REQUEST_URI"] == '/add.php'){echo 'selected';}?>">Add component</a></li>
		<li><a href="shoplist.php" class="<?php if ($_SERVER["REQUEST_URI"] == '/shoplist.php'){echo 'selected';}?>">Shopping list</a></li>
		<li><a href="proj_list.php" class="<?php if ($_SERVER["REQUEST_URI"] == '/proj_list.php' or isset($_GET['proj_id'])){echo 'selected';}?>">Projects</a></li>
		<li><a href="my.php" class="<?php if ($_SERVER["REQUEST_URI"] == '/my.php'){echo 'selected';}?>">My account</a></li>
		<li class="public"><a href="public.php" class="<?php if ($_SERVER["REQUEST_URI"] == '/public.php'){echo 'selected';}?>">Public components</a></li>
	</ul>
</div>