<?php 
require_once('../includes/initialize.php');

//$user = User::find_by_id($session1->user_id);

if(isset($_POST['submit'])) {
      
    //$found_user = User::find_by_id($session1->user_id);
     
    //if all fields are filled in    
    
    $first_name = $database->escape_value(trim($_POST['First_name']));
    $last_name = $database->escape_value(trim($_POST['Last_name']));
    $emailadd = $database->escape_value(trim($_POST['Email']));
    $Emessage = $database->escape_value(trim($_POST['Message']));
    
//    $required_fields = array('First_name','Last_name','Email', 'Message');
    
    
//    if(validate_presences($required_fields)){
    
        $mailman = New Mailman;
        
        //$mailman->touser = User::find_by_id(22); 
        //$mailman->fromuser = User::find_by_id(22);
        
        $mailman->fname = $first_name;
        $mailman->lname = $last_name;
        $mailman->emailadd = $emailadd;
        $mailman->Emessage = $Emessage;
        
        //Mailman::try_to_send_mail_to_Admin($first_name, $last_name, $emailadd, $Emessage="");
        $mailman->try_to_send_mail_to_Admin();
        
        
        
        $message = "Message Sent";
    
//    }
    

        }
        
    else {
    // Do nothing
}

?>


<?php 
include_layout_template("header2.php");  



?>

<a href="user_home.php">&laquo; Back</a><br />

    <h2>Contact Us <?php //echo $Session1->admin_id; ?></h2>
        <?php if(!empty($message)) { 
	echo output_message($message);
    }
        if(!empty($errors)) { 
	echo output_message($errors);
    }
    
    
    ?>
    
    </br>
    
    <form action="contact_us.php" method="post">
    
        First Name:</br><input type="text" value="" Name="First_name">
        </br>
        </br>
        Last Name:</br><input type="text" value="" Name="Last_name">
        </br>
        </br>
        E-mail:</br><input type="text" value="" Name="Email">
        </br>
        </br>
        Message / Question:</br><textarea rows="20" cols="60" Name="Message"></textarea>
        </br>
        </br>
        <input type="submit" value="Submit" Name="submit">
        
    </form>

<?php 
include_layout_template("footer2.php")
?>
					