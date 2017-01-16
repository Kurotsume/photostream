<?php

// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Comment extends DatabaseObject {
  
  protected static $table_name="comments";
  protected static $db_fields=array('id','photograph_id', 'created', 'author', 'body');
  
  public $id;
  public $photograph_id;
  public $created;
  public $author;
  public $body;
  
  public static function make($photo_id, $author="Anonymous", $body="") {
    if(!empty($photo_id) && !empty($author) && !empty($body)) {
    	$comment = new Comment();
    	$comment->photograph_id = (int)$photo_id;
    	$comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
    	$comment->author = $author;
    	$comment->body = $body;
    	return $comment;    
    } else {
      	return false;
    }
  }
    
  public static function find_comments_on($photo_id=0) {
    global $database;
    $sql = "SELECT * FROM " . self::$table_name;
    $sql .= " WHERE photograph_id=" .$database->escape_value($photo_id);
    $sql .= " ORDER BY created ASC";
    return self::find_by_sql($sql);
 } 
 
 public function try_to_send_notification() {
    date_default_timezone_set('Etc/UTC');
    
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;

    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

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
    $mail->setFrom('admin@localhost.com', 'Admin');

    //Set an alternative reply-to address
    $mail->addReplyTo('admin@localhost.com', 'Admin');

    //Set who the message is to be sent to
    $mail->addAddress('boweezy777@yahoo.com', 'Boris');

    //Set the subject line
    $mail->Subject = 'New Photo Gallery Comment';

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), "/var/www/ExerciseFiles/Chapter_15/15_03/btb_sandbox/examples/");
    
    $created = datetime_to_text($this->created);
    $mail->Body = <<<EMAILBODY

A new comment has been received in the Photo Gallery.

At {$created}, {$this->author} wrote:

{$this->body}

EMAILBODY;

    //'A new comment has been received.';

    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';

    $result = $mail->Send();
    return $result;
  
}
		//Common database methods
	    
	  public static function find_all(){
	      //global $database;
	      $sql = "SELECT * FROM ". static::$table_name;
	      //$result_set = User::find_by_sql($sql);
	      return static::find_by_sql($sql);
	  }

	  public static function find_by_id($id = 0){
	      global $database;
	  	  $sql = "SELECT * FROM ". static::$table_name . " WHERE id = {$id} LIMIT 1";
	      $result_array = self::find_by_sql($sql);
	  	  //$found = $database->fetch_array($result_set);
		  return !empty($result_array) ? array_shift($result_array) : false;
	  }
	  
	  public static function find_by_photo_id($id = 0){
	      global $database;
	  	  $sql = "SELECT * FROM ". static::$table_name . " WHERE photograph_id = {$id}";
	      $result_array = self::find_by_sql($sql);
	  	  //$found = $database->fetch_array($result_set);
		  return !empty($result_array) ? $result_array : false;
	  }
	  	  
	  public static function find_by_sql($sql=""){
	      global $database;
	      $result_set = $database->query($sql);
		  $object_array = array();
		  
		  while ($row = $database->fetch_array($result_set)) {
		  		$object_array[] = static::instantiate($row);
		  }
		  
	  	  return $object_array;
	  }
	
	public static function view_comments($id) {
	   $comments = static::find_by_photo_id($id);
	  if($comments){
	  echo "<table id =\"comments_table\" style=\"width: 50%; margin: 0 auto; text-align: left\">";
	  	while(0<count($comments)){
	    		$comment = array_shift($comments);
	    		echo "<tr id =\"comments_table\"><td id =\"comments_table\">". html_entities($comment->author) . "</td><td id =\"comments_table\">". strip_tags($comment->body,'<strong><em><p>') . "</td></tr>";
	    	}
	  echo "</table>";
	  };
	}
	  
	  private static function instantiate($record){
	  		  //Could check that a $record exists and is an array
			  // Simple, long-form approach;
	  		  $object = new static;
	  		  //$user->id = $record['id'];
	  		  //$user->username = $record['username'];
	  		  //$user->password = $record['password'];
	  		  //$user->last_name = $record['last_name'];
			  
			  //More dynamic, short-form approach;
			  foreach($record as $attribute=>$value){
			  	if($object->has_attribute($attribute)){
					$object->$attribute = $value;
				}
			  }
			  return $object;
	  }
	  
	  private function has_attribute($attribute){
	  	  //get_object_vars returns an associative array with all attributes
		  //(including private ones!) as the keys and their current values as the value
		  $object_vars = get_object_vars($this);
		  //Don't care about the value, we just want to know if the key exists
		  //return true of false
		  return array_key_exists($attribute, $object_vars);
	  }
	  
	  

	
}

?>