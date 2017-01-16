<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');

if (!$session1->is_admin_logged_in()) { redirect_to("admin_login.php"); }

$max_file_size = 1048576;

if(isset($_POST['submit'])) {
  $photo = new Photograph();
  $photo->caption = $_POST['caption'];
  $photo->attach_file($_FILES['file_upload']);
  if($photo->photo_save()) {
    //Success
    $session1->message( "Photograph upload successfully.");
    redirect_to('photo_stream.php');
     } else {
    //Failure
    $message = join("<br />", $photo->errors);
  }
}
?>
<?php 
include_layout_template("admin_header2.php"); 
?>
<a href="index2.php">&laquo; Back</a><br />

	<h2>Photo Upload</h2>
	
	<?php
	if(isset($message)){
	  echo output_message($message);
	}
	?>
	
	<form action="photo_upload.php" enctype="multipart/form-data" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo  $max_file_size; ?>" />
		<p><input type="file" name="file_upload" /></p>
		<p>Caption:<input type="text" name="caption" value="" /></p>
		<input type="submit" name="submit" value="Upload" />
	</form>
	
			</div>
<?php 
include_layout_template("admin_footer2.php");
?>
					