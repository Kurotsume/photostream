<?php

// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Mailman {
//class Mailman extends DatabaseObject {

public $touser; 
public $fromuser;

public $fname;
public $lname;
public $emailadd;
public $Emessage;
    
 public function try_to_send_mail() {
 
    date_default_timezone_set('Etc/UTC');
    
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    //$mail->SMTPDebug = 2;

    //Ask for HTML-friendly debug output
    //$mail->Debugoutput = 'html';

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "boweezy777@gmail.com";

    //Password to use for SMTP authentication
    $mail->Password = "Naruto777!";

    //Set who the message is to be sent from
    $mail->setFrom($this->fromuser->email, $this->fromuser->first_name);

    //Set an alternative reply-to address
    $mail->addReplyTo($this->fromuser->email, $this->fromuser->first_name);

    //Set who the message is to be sent to
    $mail->addAddress($this->touser->email, $this->touser->first_name);

    //Set the subject line
    $mail->Subject = 'Message From Photo Gallery';

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), "/var/www/ExerciseFiles/Chapter_15/15_03/btb_sandbox/examples/");
    
    $created = datetime_to_text(strftime("%Y-%m-%d %H:%M:%S", time()));
    
    $mail->Body =$this->Emessage;

    //'A new comment has been received.';

    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';

    $result = $mail->Send();
    return $result;
  
}

public function try_to_send_mail_from_Admin() {
 
 
    date_default_timezone_set('Etc/UTC');
    
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    //$mail->SMTPDebug = 2;

    //Ask for HTML-friendly debug output
    //$mail->Debugoutput = 'html';

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "boweezy777@gmail.com";

    //Password to use for SMTP authentication
    $mail->Password = "Naruto777!";

    //Set who the message is to be sent from
    $mail->setFrom('admin@thephotostream.org', 'Admin');

    //Set an alternative reply-to address
    $mail->addReplyTo('admin@thephotostream.org', 'Admin');

    //Set who the message is to be sent to
    $mail->addAddress($this->touser->email, $this->touser->first_name);

    //Set the subject line
    $mail->Subject = 'Message From Photo Gallery';

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), "/var/www/ExerciseFiles/Chapter_15/15_03/btb_sandbox/examples/");
    
    $created = datetime_to_text(strftime("%Y-%m-%d %H:%M:%S", time()));
    
    $mail->Body =$this->Emessage;

    $result = $mail->Send();
    
    return $result;
  
}

public function try_to_send_mail_to_Admin() {
    date_default_timezone_set('Etc/UTC');
    
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    //$mail->SMTPDebug = 2;

    //Ask for HTML-friendly debug output
    //$mail->Debugoutput = 'html';

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "boweezy777@gmail.com";

    //Password to use for SMTP authentication
    $mail->Password = "Naruto777!";


    //Set who the message is to be sent from
    $mail->setFrom($this->emailadd, $this->fname. " " . $this->lname);

    //Set an alternative reply-to address
    $mail->addReplyTo($this->emailadd, $this->fname. " " . $this->lname);

    //Set who the message is to be sent to
    $mail->addAddress('admin@thephotostream.org', 'Admin');

    //Set the subject line
    $mail->Subject = 'Contact Us - Photo Gallery Message';

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), "/var/www/ExerciseFiles/Chapter_15/15_03/btb_sandbox/examples/");
    
    $created = datetime_to_text(strftime("%Y-%m-%d %H:%M:%S", time()));
    
    $mail->Body =$this->Emessage;

    $result = $mail->Send();
    
    return $result;
  
}



}


?>