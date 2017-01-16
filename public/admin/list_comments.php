<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');

if (!$session1->is_admin_logged_in()) { redirect_to("admin_login.php"); }

	$photo_id = $_GET['id'];
	$attribute = Photograph::find_by_id($photo_id);
?>

<?php 
include_layout_template("admin_header2.php"); 
?>
<a href="photo_stream.php">&laquo; Back</a><br />

	<h2>Photo Stream</h2>
		<?php
	if(isset($message)){
	  echo output_message($message);
	}
	?>
	

	    	<img src="../<?php echo $attribute->image_path() ?>" title="<?php echo $attribute->caption?>" alt="<?php echo $attribute->caption?>" style="width:500px">
	   	<br />
	   	<?php echo "<a href=\"delete_photo.php?id={$attribute->id}\">Delete photo</a>" ;?>
	   	<br /><br /><br />
	   	<?php $comments = $attribute->comments()?>
	   	
	   	<div id="comments" style="text-align: center">

			<?php foreach($comments as $comment): ?>
			<div class="comment" style="margin-bottom: 2em;">
				<div class="author">
					<?php echo htmlentities($comment->author); ?> wrote:
				</div>
			<div class="body">
				<?php echo strip_tags($comment->body,'<strong><em><p>'); ?>
			</div>
			<div class="meta-info" style="font-size: 0.8em">
				<?php echo datetime_to_text($comment->created); ?>
			</div>
			<div class="c_delete">
				<?php  echo "<a href=\"delete_comment.php?id={$comment->id}\"> Delete Comment</a>"; ?>
			</div>
		</div>
		
	<?php endforeach; ?>
	
	<?php if(empty($comments)) { echo "No Comments."; } ?>
	
</div>

	   	
	   <?php //}
	?>
	
	
	<br /><br />
	<a href="photo_upload.php">Upload New Picture</a><br/><br/>
	
	
			</div>
<?php 
include_layout_template("admin_footer2.php");
?>
					