<?php 
require_once('../includes/initialize.php');

if(!$session1->is_logged_in()) {
 redirect_to("user_login.php");
}

$user = User::find_by_id($session1->user_id);

if(isset($_POST['submit'])) {

    $username = trim($_POST['Username']);
    $oldpassword = trim($_POST['Oldpassword']);
    $password1 = trim($_POST['Password1']);
    $password2 = trim($_POST['Password2']);
    $first_name = trim($_POST['First_name']);
    $last_name = trim($_POST['Last_name']);
    $email = trim($_POST['Email']);

    $username = $database->escape_value($_POST['Username']);
    $oldpassword = $database->escape_value($_POST['Oldpassword']);
    $password1 = $database->escape_value($_POST['Password1']);
    $password2 = $database->escape_value($_POST['Password2']);
    $first_name = $database->escape_value($_POST['First_name']);
    $last_name = $database->escape_value($_POST['Last_name']);
    $email = $database->escape_value($_POST['Email']);
    
    $user_role = 2;

    // Check database to see if username/password exist.
      
    $found_user = User::find_by_id($session1->user_id);
     
    
    //if all fields are filled in
    
    if($username<>""){
        $found_user->username = $username;
        $message .= "Username changed!</br>";
    }        
    
    if($oldpassword<>""){
        if($found_user->password == $oldpassword){
            if($password1 == $password2){
                $found_user->password = $password1;
                $message .= "Password changed!</br>";
            } else{
                $message .= "New passwords are not the same!!</br>";
            }
        }else{
            $message .= "Old password does not match!!</br>";
        }
    }
    
    if($first_name<>""){
        $found_user->first_name = $first_name;
        $message .= "First name changed!!</br>";
    }
    
    if($last_name<>""){
        $found_user->last_name = $last_name;
        $message .= "Last name changed!!</br>";
    }
    
    if($email<>""){
        $found_user->email = $email;
        $message = "Email changed!!</br>";
    }  
    
    $found_user->save();
    redirect_to("edit_user.php");

        }
        
    else {
    
    // Do nothing
}

?>


<?php 
include_layout_template("header2.php");  



?>

<a href="user_home.php">&laquo; Back</a><br />

    <h2>Photo Stream <?php //echo $Session1->admin_id; ?></h2>
        <?php if(!empty($message)) { 
	echo output_message($message);
    }
    ?>
    
    </br>
    
    <form action="" method="post">
    
        Username: <input type="text" value="" placeholder="<?php echo htmlentities($user->username); ?>" Name="Username">
        </br>
        </br>
        Old Password : <input type="password" value="" placeholder="<?php echo htmlentities($user->password); ?>" Name="Oldpassword">
        </br>
        </br>
        New Password : <input type="password" value="" Name="Password1">
        </br>
        </br>
        Confirm New Password : <input type="password" value="" Name="Password2">
        </br>
        </br>
        First Name: <input type="text" value="" placeholder="<?php echo htmlentities($user->first_name); ?>" Name="First_name">
        </br>
        </br>
        Last Name: <input type="text" value="" placeholder="<?php echo htmlentities($user->last_name); ?>" Name="Last_name">
        </br>
        </br>
        E-mail: <input type="text" value="" placeholder="<?php echo htmlentities($user->email); ?>" Name="Email">
        </br>
        </br>
        <input type="submit" value="Submit" Name="submit">
        
    </form>

<?php 
include_layout_template("footer2.php")
?>
					