<?php 
require_once('../includes/initialize.php');

if(!$session1->is_logged_in()) {
 redirect_to("user_login.php");
}

$folder_id = clean(trim($_GET['id']));
$user = User::find_by_id($session1->user_id);
$folder = Folder::find_userfolder_by_id($folder_id,$session1->user_id);

if(isset($_POST['submit'])) {

    // Check database to see if folder exists      
    if($folder){
        $new_name = strtolower(clean(trim($_POST['foldername'])));

        //if the foldername is filled in
        if($new_name <> ""){
            $folder->foldername = $new_name;
            $folder->location = $user->id . DS .$new_name;
            $folder->dir_update();
            
            redirect_to("manage_folders.php");

        }else{
            $message = "New Folder must have a name.";                       
        }  

    }else{
        $message = "Could not find folder in database.";
    }
        
}else {    
// Do nothing
}


?>


<?php 
include_layout_template("header2.php");  
?>

<a href="manage_folders.php">&laquo; Back</a><br />

    <h2>Photo Stream <?php //echo $Session1->admin_id; ?></h2>
        <?php if(!empty($message)) { echo output_message($message); } ?>
    </br>
    
    <form action="" method="post">
    
        New name for Folder: <input type="text" value="" placeholder="<?php echo htmlentities($folder->foldername); ?>" Name="foldername">
        </br>
        </br>        
        <input type="submit" value="Edit" Name="submit">&nbsp;&nbsp; <button type="button" href="manage_folders.php">Cancel</button>
        
    </form>

<?php 
include_layout_template("footer2.php")
?>
					