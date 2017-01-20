<?php 
require_once('../includes/initialize.php');

if(!$session1->is_logged_in()) {
 redirect_to("user_login.php");
}

$folder_id = trim($_GET['id']);
$user = User::find_by_id($session1->user_id);
$folder = Folder::find_userfolder_by_id($folder_id,$session1->user_id);
$folder->destroy();
redirect_to("manage_folders.php");

?>

				