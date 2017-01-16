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
    redirect_to('photo_stream.php');
  }
  
  $comment= Comment::find_by_id($_GET['id']);
  if( $comment && $comment->delete()) {
    $session1->message("Comment deleted.");
    redirect_to('photo_stream.php');
  } else {
    $session1->message("The comment could not be deleted.");
    redirect_to('delete_comment.php?id={$comment->id}');
  }

?>
<?php if(isset($database)) { $database->close_connection();} ?>					