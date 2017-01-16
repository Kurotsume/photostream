<?php 
require_once('../includes/initialize.php');

if(!$session1->is_logged_in()) {
 redirect_to("user_home.php");
}


picture_loader();

?>

<?php 
include_layout_template("header2.php"); 
?>
<a href="user_home.php">&laquo; Back</a><br />

	<h2>Photo Upload</h2>
	
	<?php
	if(isset($message)){
	  echo output_message($message);
	}
	
	picture_form();
	?>
	

	
			</div></br></br></br>
<?php 
include_layout_template("footer2.php");
?>
					