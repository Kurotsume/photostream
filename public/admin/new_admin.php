<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');

if (!$session1->is_admin_logged_in()) { redirect_to("admin_login.php"); }

if(isset($_POST['submit'])) {

    $username = trim($_POST['Username']);
    $password = trim($_POST['Password']);
    $first_name = trim($_POST['First_name']);
    $last_name = trim($_POST['Last_name']);
    $user_role = trim($_POST['Role']);

    // Check database to see if username/password exist.
      
    $found_user = User::find_by_username($username);
    
    //if all fields are filled in
    
    //if password is okay
    
    //if role is set
    
      if($found_user) {
            $message = "User already exists in database.";
            

        } else {
            //Create User
            
            User::create_post_user($username, $password, $first_name, $last_name, $user_role);
            $message = "User created!.";
            
        }
    
    } else {
    
    // Do nothing
}

?>


<?php 
include_layout_template("admin_header2.php"); 
?>

<a href="manage_users.php">&laquo; Back</a><br />

    <h2>Photo Stream <?php //echo $Session1->admin_id; ?></h2>
        <?php if(!empty($message)) { 
	echo output_message($message);
    }
    ?>
    
    </br>
    
    <form action="new_admin.php" method="post">
    
        Username: <input type="text" Value="" Name="Username">
        </br>
        </br>
        Password : <input type="text" Value="" Name="Password">
        </br>
        </br>
        First Name: <input type="text" Value="" Name="First_name">
        </br>
        </br>
        Last Name: <input type="text" Value="" Name="Last_name">
        </br>
        </br>
        Role:<select name="Role">
        <option value="1">Admin</option>
        <option value="2">User</option>
        <!--<option value="3">Opel</option>
        <option value="4">Audi</option>-->
        </select>
        </br>
        </br>
        <input type="submit" Value="Submit" Name="submit">
        
    </form>

<?php 
include_layout_template("admin_footer2.php");
?>
					