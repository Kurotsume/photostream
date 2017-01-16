<?php 
require_once('../../includes/initialize.php');
require_once('../../includes/functions.php');
require_once('../../includes/session1.php');

if (!$session1->is_admin_logged_in()) { redirect_to("admin_login.php"); }

// must have an ID
if(empty($_GET['id'])) {
    $session1->message("No user ID was provided.");
    redirect_to('manage_users.php');
}

$user_object = User::find_by_id($_GET['id']);

if(isset($_POST['submit'])){
    // make changes
    
      
    if(!empty($_POST['username']) && $user_object->find_by_username($_POST['username']) == false) {
        //update username
        $user_object->username = $_POST['username'];
        $message .= "Username updated!</br>";        
    } elseif($_POST['username'] = $user_object->username){
        // it was empty 
        $message .= "Username not changed: Username already exists in database.</br>";
    }
    
    
    if(!empty($_POST['password']) && $_POST['password'] <> $user_object->username) {
        //update user password
        $user_object->password = $_POST['password'];
        $message .= "Password updated!</br>";        
    } elseif($_POST['password'] = $user_object->password){
        // it was empty 
        $message .= "Password not changed: Must be different then the current one.</br>";
    }
    
    
    if(!empty($_POST['first_name']) && $_POST['first_name'] <> $user_object->first_name) {
        //update user first name
        $user_object->first_name = $_POST['first_name'];
        $message .= "User first name updated!</br>";             
    } elseif($_POST['first_name'] = $user_object->first_name){
        // it was empty 
        $message .= "First name not changed: Must be different then the current one.</br>";
    }
    
    
    if(!empty($_POST['last_name']) && $_POST['last_name'] <> $user_object->last_name) {
        //update user last name
        $user_object->last_name = $_POST['last_name'];
        $message .= "User last name updated!</br>";       
    } elseif($_POST['last_name'] = $user_object->last_name){
        // it was empty 
        $message .= "Last name not changed: Must be different then the current one.</br>";
    }
    
    
    if($_POST['role'] <> $user_object->user_role){
        // update user role
        $user_object->user_role = $_POST['role'];
        $message .= "User role updated!</br>";      
    } else {
    
    }
        $user_object->save();        
    

}    
?>



<?php 
include_layout_template("admin_header2.php"); 
?>

<a href="manage_users.php">&laquo; Back</a><br />

	<h2>Edit User<?php //echo $Session1->admin_id; ?></h2>
	
<?php   

if(isset($message)){
echo output_message($message);
}
?>

<form action="edit_user.php?id=<?php echo $user_object->id;?>" method="post">
<table cellspacing="5">
    <tr><td style="padding:0 20px 0 0px;">Username: </td><td><input type="text" name="username" placeholder="<?php echo htmlentities($user_object->username); ?>"></input></br></tr></td>
    <tr><td style="padding:0 20px 0 0px;">Password: </td><td><input type="password" name="password" placeholder=""></input></br></tr></td>
    <tr><td style="padding:0 20px 0 0px;">First Name: </td><td><input type="text" name="first_name" placeholder="<?php echo htmlentities($user_object->first_name); ?>"></input></br></tr></td>
    <tr><td style="padding:0 20px 0 0px;">Last Name: </td><td><input type="text" name="last_name" placeholder="<?php echo htmlentities($user_object->last_name); ?>"></input></br></tr></td>
</table>

<select name="role">
<?php

if($user_object->user_role == 1) {
echo "<option value=\"1\" selected>Admin</option><option value=\"2\">User</option>";
} else {
echo "<option value=\"1\">Admin</option><option value=\"2\" selected>User</option>";
}

?>
</select>
</br>
</br>
<input type="submit" Value="Edit" Name="submit">

<?php 
include_layout_template("admin_footer2.php");
?>
					