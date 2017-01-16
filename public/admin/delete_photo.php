<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');

if (!$session1->is_admin_logged_in()) { redirect_to("admin_login.php"); }
?>

<?php 
  // must have an ID
  if(empty($_GET['id'])) {
    $session1->message("No photograph ID was provided.");
    redirect_to('index2.php');
  }
  
  $photo = Photograph::find_by_id($_GET['id']);
  if($photo && $photo->destroy()) {
    $session1->message("The photo was deleted.");
    redirect_to('photo_stream.php');
  } else {
    $session1->message("The photo could not be deleted.");
    redirect_to('photo_stream.php');
  }

?>
<?php if(isset($database)) { $database->close_connection();} ?>					