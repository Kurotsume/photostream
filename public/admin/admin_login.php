<?php 
require_once('../../includes/initialize.php');
//require_once('../../includes/functions.php');
//require_once('../../includes/session1.php');
//require_once('../../includes/database.php');
//require_once('../../includes/user1.php');

if ($session1->is_admin_logged_in()) {
redirect_to("index2.php"); 
//echo "Admin is not logged in.";
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { // Form has been submitted.

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
      
      // Check database to see if username/password exist.
      
      $found_user = User::authenticate($username, $password);
       
    if ($found_user) {
	$session1->login($found_user);
        if($session1->is_admin_logged_in()) {
	  Logger::log_action("Login", "The user {$found_user->username} logged in.");
	  redirect_to("index2.php");
	}else {       
	  // username/password combo was not found in the database
	  $message = "Username/password combination incorrect.";
	  //echo "Bad match";
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
		<title>StreaMage</title>
		<link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="header">
			<h1>StremMage</h1>
		</div>
		<div id="main">
		<h2>Staff Login</h2>
		<?php if(!empty($message)) { 
		echo output_message($message);
		}
		?>
		
		<form action="admin_login.php" method="post">
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
			<a href="../index1.php">Home</a><br/><br/>
		</div>
		<div id="footer">Copyright <?php echo date("Y", time()); ?>, Boris Thertus</div>
	</body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>