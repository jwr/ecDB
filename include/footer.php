<div id="copyText">
    <div class="leftBox">
        <div>© 2010 - <?php echo date('Y'); ?> ecDB - Created by <a href="http://nilsf.se">Nils Fredriksson</a> - <a href="contact.php">Contact us</a> - <a href="terms.php">Terms & Privacy</a></div>
        <div class="stats">
            <?php include_once('include/mysql_connect.php'); ?>

        	<?php $members = mysql_num_rows(mysql_query("SELECT member_id FROM members")); echo $members; ?>
			<span class="boldText">members</span>,

			<?php $components = mysql_num_rows(mysql_query("SELECT id FROM data")); echo $components; ?>
			<span class="boldText">components </span>and

			<?php $projects = mysql_num_rows(mysql_query("SELECT project_id FROM projects")); echo $projects; ?>
			<span class="boldText">projects</span>.

        </div>
    </div>
    <div class="rightBox">
        Design by <a href="http://www.buildlog.eu"><span class="blIcon"></span></a>
    </div>
</div>