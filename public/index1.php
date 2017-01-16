<?php
require_once('../includes/initialize.php');
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

<div id="row">
<?php
	foreach($photos as $photo): ?>
		<div class="col-sm-4 col-xs-6">
                    <p>
			<a href="photo.php?id=<?php echo $photo->id; ?>">
                            <img src="<?php echo $photo->image_path(); ?>" class="img-responsive" />
			</a>
                        <p><?php echo $photo->caption; ?></p>
                    </p>	
		</div>
	<?php endforeach; ?>

</div> <!--ends row -->

<div id="row">

    <div id="pagination" style="clear: both">    

        <?php if($pagination->total_pages() >= 1) {
            
            if($pagination->has_previous_page()) {
                echo " <a href=\"index1.php?page=";
                echo $pagination->previous_page();
                echo "\">&laquo; Previous </a> ";
            }
            
            for($i=1; $i <= $pagination->total_pages(); $i++) {
                if($i == $page) {
                    echo " <span class=\"selected\">{$i}</span> ";
                } else {
                    echo "<a href=\"index1.php?page={$i}\">{$i}</a> ";
                }
            }
            
            if($pagination->has_next_page()) {
                echo " <a href=\"index1.php?page=";
                echo $pagination->next_page();
                echo "\">Next &raquo;</a>";
            }
        } ?>           
    	 
    </div>
    
</div>
<?php include_layout_template("footer2.php"); ?>
