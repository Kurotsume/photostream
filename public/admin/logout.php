<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');


$session1->logout();

if (!$session1->is_logged_in()) { redirect_to("admin_login.php"); }



 ?>
					