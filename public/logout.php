<?php 
require_once('../includes/initialize.php');


$session1->logout();

if (!$session1->is_logged_in()) { redirect_to("user_login.php"); }



 ?>
					