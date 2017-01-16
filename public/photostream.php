<?php
require_once('../includes/initialize.php');
?>

<?php $photos = Photograph::find_all(); ?>

<?php include_layout_template("header2.php"); ?>

<div id="row">
    <a href="user_home.php">Home</a> 

    <?php
        if(isset($message)){
            echo output_message($message);
        }
    ?>
</div>
	
<div id="row">

    <?php foreach($photos as $photo) : ?>
        <div class="col-sm-4 col-xs-6">
                <p>
                    <a href="photo.php?id=<?php echo $photo->id; ?>">
                        <img src="<?php echo $photo->image_path() ?>" title="<?php echo $photo->caption ?>" alt="<?php echo $photo->caption ?>" class="img-responsive"/>
                    </a>
                        <p><?php echo $photo->caption; ?></p>
                </p>	            
        </div>
    <?php endforeach; ?>

</div>


<?php include_layout_template("footer2.php"); ?>
