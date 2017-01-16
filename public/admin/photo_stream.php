<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');

if (!$session1->is_admin_logged_in()) { redirect_to("admin_login.php"); }

?>

<?php 
include_layout_template("admin_header2.php"); 
?>
<a href="index2.php">&laquo; Back</a><br />

	<h2>Photo Stream</h2>
		<?php
	if(isset($message)){
	  echo output_message($message);
	}
	?>
	
	<?php
	$photolist = Photograph::find_all();
			
	  foreach($photolist as $attribute){ ?>
	    	<!--echo '"<img src="'. $imgfolder . $attribute->filename . '" alt="'. $attribute->caption .'" style="width:500px;">' ;-->
	    	<img src="../<?php echo $attribute->image_path() ?>" title="<?php echo $attribute->caption?>" alt="<?php echo $attribute->caption?>" style="width:500px">
	   	<br />
	   	<?php echo "<a href=\"delete_photo.php?id={$attribute->id}\">Delete photo</a>" ;?>
	   	<br /><br /><br />
	   	
	   	
		<div class="c_delete">
		<?php 
			$num_comments =count($attribute->comments());
			if($num_comments <> 1) {
				echo $num_comments ." Comments" ;
			}else{			  
				echo $num_comments  ." Comment" ;
			}
      
      ; 
		
		?>
		
		</br>		
			<?php  echo "<a href=\"list_comments.php?id={$attribute->id}\"> Delete Comment</a>"; ?>
		</div>


	   	
	   <?php }
	?>
	
	
	<br /><br />
	<a href="photo_upload.php">Upload New Picture</a><br/><br/>
	
	
			</div>
<?php 
include_layout_template("admin_footer2.php");
?>
					