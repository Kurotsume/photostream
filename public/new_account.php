<?php 
require_once('../includes/initialize.php');


if(isset($_POST['submit'])) {

    $username = cleanUP(trim($_POST['Username']));
    $password1 = cleanUP(trim($_POST['Password1']));
    $password2 = cleanUP(trim($_POST['Password2']));
    $first_name = cleanUP(trim($_POST['First_name']));
    $last_name = cleanUP(trim($_POST['Last_name']));
    $email = trim($_POST['Email']);

    $user_role = 2;

    // Check database to see if username/password exist.
      
    $found_user = User::find_by_username($username);
    
    //if all fields are filled in
    
    //if password is okay
    
    //if role is set
    
      if($found_user) {
            $message = "User already exists in database.";
            

        } else {
            //Create User
            
            if($password1==$password2){
            	
            	$password = password_encrypt($password1);
            	User::create_post_user($username, $password, $first_name, $last_name, $user_role, $email);
            	$message = "Account created!. We emailed you at " . $email . "!";
            
            }
        }
    
    } else {
    
    // Do nothing
}

?>


<?php 
include_layout_template("header2.php");  
?>

<a href="index1.php">&laquo; Back</a><br />


    
<!--  
    <h2>Photo Stream</h2>
    
</br>
    <form action="new_account.php" method="post">
    
        <div class="row-lg-3">
                <label>Username</label>
                <input type="text" class="form-control" Value="" Name="Username">
        </div></br>
   
        <div class="row-lg-3">
                <label>Password</label> 
                <input type="password" class="form-control" Value="" Name="Password">
        </div></br>
  
        <div class="col-lg-2">
                <label>Confirm Password</label> 
                <input type="password" class="form-control" Value="" Name="Password">
        </div></br>
   
        <div class="col-lg-2">
                <label>First Name</label> 
                <input type="text" class="form-control" Value="" Name="First_name">
        </div></br>
     
        <div class="col-lg-2">
                <label>Last Name</label> 
                <input type="text" class="form-control " Value="" Name="Last_name">
        </div></br>
 
        <div class="col-lg-2">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <input type="text" class="form-control" Value="" Name="Email">
        </div></br>

        
        <button type="submit" class="btn btn-primary" Value="Submit" Name="submit">Submit</button>
        
    </form>
-->        
    <script src="javascripts/charactercheck.js" type="text/javascript"></script>

        <h1>Sign Up</h1></br>
                <?php if(!empty($message)) { 
	echo output_message($message);
    }
    ?>
    <form action="new_account.php" method="post" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-xs-3" for="inputUsername">* Username:</label>
            <div class="col-xs-9">
                <input type="username" class="form-control" id="input" placeholder="Username" Name="Username">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="inputPassword">* Password:</label>
            <div class="col-xs-9">
                <input type="password" class="form-control" id="input" placeholder="Password" Name="Password1">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="confirmPassword">* Confirm Password:</label>
            <div class="col-xs-9">
                <input type="password" class="form-control" id="input" placeholder="Confirm Password" Name="Password2">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="firstName">* First Name:</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="input" placeholder="First Name" Name="First_name">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="lastName">* Last Name:</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="input" placeholder="Last Name" Name="Last_name">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="phoneNumber">Phone:</label>
            <div class="col-xs-9">
                <input type="tel" class="form-control" id="input" placeholder="Phone Number" Name="Phone">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="inputEmail">* Email:</label>
            <div class="col-xs-9">
                <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="Email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3">Date of Birth:</label>
            <div class="col-xs-3">
                <select class="form-control">
                    <option>Date</option>
                </select>
            </div>
            <div class="col-xs-3">
                <select class="form-control">
                    <option>Month</option>
                </select>
            </div>
            <div class="col-xs-3">
                <select class="form-control">
                    <option>Year</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="postalAddress">Address:</label>
            <div class="col-xs-9">
                <textarea rows="3" class="form-control" id="postalAddress" placeholder="Postal Address"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="ZipCode">Zip Code:</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="input" placeholder="Zip Code">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3">Gender:</label>
            <div class="col-xs-2">
                <label class="radio-inline">
                    <input type="radio" name="genderRadios" value="male"> Male
                </label>
            </div>
            <div class="col-xs-2">
                <label class="radio-inline">
                    <input type="radio" name="genderRadios" value="female"> Female
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-3 col-xs-9">
                <label class="checkbox-inline">
                    <input type="checkbox" value="news"> Send me latest news and updates.
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-3 col-xs-9">
                <label class="checkbox-inline">
                    <input type="checkbox" value="agree">  I agree to the <a href="#">Terms and Conditions</a>.
                </label>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-xs-offset-3 col-xs-9">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                <!--<input type="reset" class="btn btn-default" value="Reset">-->
            </div>
        </div>
    </form>

      
<?php 
include_layout_template("footer2.php")
?>
					