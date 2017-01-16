<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');

if (!$session1->is_admin_logged_in()) { redirect_to("admin_login.php"); }


$user_array = User::find_all();

?>

<?php 
include_layout_template("admin_header2.php"); 
?>
<a href="index2.php">&laquo; Back</a><br />

	<h2>Manage Users<?php //echo $Session1->admin_id; ?></h2>
	
		<?php
	if(isset($message)){
	  echo output_message($message);
	}
	?>
	
	<br /><br />
	
	<table cellspacing="5">
	<tr><td><h3>Username</h3></td><td><h3>Actions</h3></td></tr>
            <?php
                foreach($user_array as $user) {
                    echo "<tr><td style=\"padding:0 20px 0 0px;\">" . htmlentities($user->username) . " </td><td>" . "<a href=\"edit_user.php?id=" . htmlentities($user->id) . "\">Edit</a> " . "<a href=\"delete_user.php?id=" . htmlentities($user->id) . "\">Delete</a>" . "</td></tr>";
                }
            ?>
	</table>
	
	
	
	
	<br/><br/>
	<a href="new_user.php">Add New User</a>


</div>

	   	
	   <?php //}
	?>
	
	
	
	
	
			</div>
<?php 
include_layout_template("admin_footer2.php");
?>
					