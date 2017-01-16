<?php 
require_once('../includes/initialize.php');


if(isset($_POST['submit'])) {

    $username = trim($_POST['Username']);
    $password = trim($_POST['Password']);
    $first_name = trim($_POST['First_name']);
    $last_name = trim($_POST['Last_name']);
    $email = trim($_POST['Email']);
    $user_role = 2;

  $username = $database->escape_value($username);
  $$password = $database->escape_value($password);
  $first_name = $database->escape_value($first_name);
  $last_name = $database->escape_value($last_name);
  $email = $database->escape_value($email);

    // Check database to see if username/password exist.
      
    $found_user = User::find_by_username($username);
    
    //if all fields are filled in
    
    //if password is okay
    
    //if role is set
    
      if($found_user) {
            $message = "User already exists in database.";
            

        } else {
            //Create User
            
            User::create_post_user($username, $password, $first_name, $last_name, $user_role, $email);
            $message = "User created!.";
            
        }
    
    } else {
    
    // Do nothing
}

?>


<?php 
include_layout_template("header2.php");  
?>

<a href="index1.php">&laquo; Back</a><br />

    <h2>Photo Stream <?php //echo $Session1->admin_id; ?></h2>
        <?php if(!empty($message)) { 
	echo output_message($message);
    }
    ?>
    
    </br>
    
    <form action="new_account.php" method="post">
    
        Username: <input type="text" Value="" Name="Username">
        </br>
        </br>
        Password : <input type="password" Value="" Name="Password">
        </br>
        </br>
        First Name: <input type="text" Value="" Name="First_name">
        </br>
        </br>
        Last Name: <input type="text" Value="" Name="Last_name">
        </br>
        </br>
        E-mail: <input type="text" Value="" Name="Email">
        </br>
        </br>
        <input type="submit" Value="Submit" Name="submit">
        
    </form>

<?php 
include_layout_template("footer2.php")
?>
					