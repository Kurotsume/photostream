<?php 
require_once('../includes/initialize.php');

if($session1->is_logged_in()) {
 redirect_to("user_home.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted.

	$username = $database->escape_value(trim($_POST['username']));
	$password = $database->escape_value(trim($_POST['password']));
      
      // Check database to see if username/password exist.
      
      $found_user = User::authenticate($username, $password);
       
      if ($found_user) {
	$session1->login($found_user);
	//echo $found_user->username . " " . $found_user->password . "IS LOGGED?". $session1->is_logged_in();
	if($session1->is_logged_in()) {
	  Logger::log_action("Login", "The user {$found_user->username} logged in.");
	  redirect_to("user_home.php");
	}
	} else {
	  // username/password combo was not found in the database
	  $message = "Username/password combination incorrect.";
	  //echo "Bad match";
	 }
	
} else { // Form has not been submitted.
	$username = "";
	$password = "";
}

?>

<html>
	<head>
		<title>Photostream</title>
		<link href="stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="header">
			<h1>Photostream</h1>
		</div>
		<div id="main">
		<h2>User Login</h2>
		<?php if(!empty($message)) { 
		echo output_message($message);
		}
		?>
		
		<form action="user_login.php" method="post">
			<table>
				<tr>
					<td>Username: </td>
					<td> 
						<input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
					</td>
				</tr>
				<tr>
					<td>Password:</td>
					<td>
						<input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
					</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" name="submit" value="Login" />
						</td>
					</tr>
			</table>
		</form>
			<a href="index1.php">Home</a><br/><br/>
		</div>
		<div id="footer">Copyright <?php echo date("Y", time()); ?>, Boris Thertus</div>
	</body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>