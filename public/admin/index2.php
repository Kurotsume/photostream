<?php 
require_once('../../includes/initialize.php');

if (!$session1->is_admin_logged_in()) {
redirect_to("admin_login.php"); 
//echo "Admin is not logged in.";
}


?>
<?php include_layout_template("admin_header2.php"); ?>
		<?php
	if(isset($message)){
	  echo output_message($message);
	}
	?>
			<h2>Menu</h2>
			<a href="../index1.php">Home</a><br/><br/>
			<a href="logfile.php">Log File</a><br/><br/>
			<a href="manage_users.php">Manage Users</a><br/><br/>
			<a href="photo_upload.php">Photo Uploader</a><br/><br/>
			<a href="photo_stream.php">Photo Stream</a><br/><br/>
			<a href="logout.php">Logout</a>
			
			</div>
<?php include_layout_template("admin_footer2.php"); ?>
					