<?php 
require_once("../includes/initialize.php");
require_once("../includes/db_connection.php");
require_once("../includes/validation_functions.php");
include_layout_template("header.php");
?>



<?php
$username = "";

if (isset($_POST['Submit'])){
  echo "Submit clicked";
   //Procsss the form
   //Validations
   $required_fields = array("username", "password");
   validate_presences($required_fields);

	if(empty($errors)){
	// Attempt Login
	$username = $_POST["username"];
	$password = $_POST["password"];
	$found_admin = attempt_login($username, $password);
	  echo "Submit clicked2";
	  
    		if ($found_admin) {
		    log_action( "Hi","Login: {$found_admin["username"]} logged in");
		    //Success
        		//Mark user as logged
			$_SESSION["admin_id"] = $found_admin["id"];
			$_SESSION["username"] = $found_admin["username"];
        		redirect_to("admin.php");
    		}
    		else {
        		//Failure
        		$_SESSION["message"] = "Username/password not found.";	
        		
    		}//END if ($found_admin) {
		
	}// END if(empty($errors)){
		
}// END if (isset($_POST['Submit'])){
		
?>	
	<?php  
	if(isset($_SESSION["message"])){
	  echo $_SESSION["message"];
	  }
	
		if(!empty($errors)){
			echo form_errors($errors); 
		}
	?>
	

<form action="login.php" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="text" name="password"><br>
<input type="submit" name="Submit" value="Submit">
</form>


<?php 
include_layout_template("footer.php");
?>
