<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');

if (!$session1->is_admin_logged_in()) { redirect_to("admin_login.php"); }
?>

<?php 
  // must have an ID
  if(empty($_GET['id'])) {
    $session1->message("No comment ID was provided.");
    redirect_to('manage_users.php');
  }
  

  $user= User::find_by_id($_GET['id']);

  if($user->user_role = 1 && User::count_all_admins() >= 2){

    if( $user && $user->delete()) {
        $session1->message("User deleted.");
        redirect_to('manage_users.php');
    } else {
        $session1->message("The user could not be deleted.");
        redirect_to('manage_users.php?id={$user->id}');
    }

    } else {
        $session1->message("There needs to be at least one admin available. The Admin could not be deleted. ");
        redirect_to('manage_users.php?id={$user->id}');
    }

?>
<?php if(isset($database)) { $database->close_connection();} ?>					