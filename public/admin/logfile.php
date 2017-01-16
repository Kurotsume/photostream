<?php
require_once('../../includes/initialize.php');

if(!$session1->is_admin_logged_in()) {
  $message = "Must be logged in to access.";
  redirect_to("admin_login.php");
}

include('../../public/layouts/admin_header2.php'); ?>

<a href="index2.php">&laquo; Back</a><br />
<br />

<h2>Log File</h2>
	<?php
	if(isset($message)){
	  echo output_message($message);
	}
	?>
			
<?php 
	if(isset($_GET['clear'])) {
	  if($_GET['clear']=='true'){
	    Logger::clear_log("Log file cleared", $session1->user_id);
	    redirect_to("logfile.php");
	  }
	}
	  
	Logger::log_list(); 

?>

<br />
<a href="logfile.php?clear=true">Clear Log File</a>

</div>

<?php 

include('../../public/layouts/admin_footer2.php');

?>