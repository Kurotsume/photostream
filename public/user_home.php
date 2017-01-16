<?php
require_once('../includes/initialize.php');

if(!$session1->is_logged_in()) {
 redirect_to("user_login.php");
}

?>

<?php 

// 1. the current page number ($current_page)
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// 2. records per page ($per_page)
$per_page = 3;

// 3. total record count ($total_count)
$total_count = Photograph::count_all();
// FInd all photos  
// use pagination instead
// $photos = Photograph::find_all();

//$photos = Photograph::find_all();

$pagination = new Pagination($page, $per_page, $total_count);

// Instead of finding all records, just find the records
// for this page

$sql = "SELECT * FROM photographs ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$photos = Photograph::find_by_sql($sql);

//Need to add ?page=$page to all links we want to
//Maintian the current page (or store $page in $session)

?>

<?php include_layout_template("header2.php"); ?>
<script>
	function makefolder(){
	if(document.getElementById("selectfolder").value == "Make new box"){
	document.getElementById("foldernamebox").disabled = false;
	}else{
	document.getElementById("foldernamebox").disabled = true;
	document.getElementById("foldernamebox").value = "";
	}
	}
</script>
<div id="row">
	<h2>Upload picture</h2>
	
	<?php
	if(isset($message)){
	  echo output_message($message);
	}
	?>
	
	<form action="photo_upload.php" enctype="multipart/form-data" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo  $max_file_size; ?>" />
		<p>Select file to upload: </br><input type="file" name="file_upload" /></p>
		<p>Add caption to image:</br><input type="text" name="caption" value="" /></p>		
		
		Make image visible to public?: </br><select name="sharephoto">
                    <option id="Show to public" value="0">Yes</option>
                    <option id="Hide to public" value="1">No</option>
		</select><br /><br />
		
		Upload to folder: </br><select name="selectfolder" id="selectfolder" onclick="makefolder()">
						
		<?php
		if($folderarray){		
                    foreach($folderarray as $folder):
                    echo "<option id=\"" . htmlentities($folder->foldername) . "\" value=\"" . htmlentities($folder->foldername) . "\">" . htmlentities(ucfirst($folder->foldername)) ."</option>";
                    
                    endforeach;
                }
		?>
                    <option id="Make new box" value="Make new box">Create new folder</br></option>
		</select><br /><br />
		
		<p>Name new folder:</br><input id="foldernamebox" type="text" name="foldernamebox" value="" disabled="true" /></p>
		
		
		
		<input type="submit" name="submit" value="Upload" />
	</form></br></br>
	
<?php
	foreach($photos as $photo): ?>
            <div class="col-sm-4 col-xs-6">
                <p>
                    <a href="photo.php?id=<?php echo $photo->id; ?>">
                        <img src="<?php echo htmlentities($photo->image_path()); ?>" class="img-responsive" />
                    </a>
                </p>
		<p><?php echo htmlentities($photo->caption); ?></p>
            </div>
	<?php endforeach; ?>

</div>


<div id="row">

    <div id="pagination" style="clear: both">    

        <?php if($pagination->total_pages() >= 1) {
            
            if($pagination->has_previous_page()) {
                echo " <a href=\"user_home.php?page=";
                echo $pagination->previous_page();
                echo "\">&laquo; Previous </a> ";
            }
            
            for($i=1; $i <= $pagination->total_pages(); $i++) {
                if($i == $page) {
                    echo " <span class=\"selected\">{$i}</span> ";
                } else {
                    echo "<a href=\"user_home.php?page={$i}\">{$i}</a> ";
                }
            }
            
            if($pagination->has_next_page()) {
                echo " <a href=\"user_home.php?page=";
                echo $pagination->next_page();
                echo "\">Next &raquo;</a>";
            }
        } ?>           
    	 
    </br></div></br>
    
</div>

<?php include_layout_template("footer2.php"); ?>
