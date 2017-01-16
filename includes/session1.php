<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with session that is generally
// inadvisable to store DB-related objects in sessions

class Session1 {
  	
  	private $logged_in=false;
  	private $admin_logged_in=false;
  	public $user_id;
  	public $admin_id;
  	public $message;
  	
  	
  	function __construct() {
		session_start();
		$this->check_message();
		$this->check_login();
		if($this->logged_in) {
		  	//action to take right away if user is logged in
		 } else {
		   // actions to take right away if user is not logged in
		  }
	
	}
		 
	public function login($user) {
        //database should find user based on username/password
	  if($user) {
	    if($user->user_role == 1){
                $this->admin_id = $_SESSION['admin_id'] = $user->id;
                $this->admin_logged_in = true;            
            } elseif($user->user_role == 2){
                $this->user_id = $_SESSION['user_id'] = $user->id;
                $this->logged_in = true;            
            }
	   }
	  }
	 
	 /* public function ad_login($admin) {
	  //database should find user based on username/password
	  if($user) {
	    $this->$admin_id = $_SESSION['admin_id'] = $admin->id;
	    $this->admin_log_in = true;
	   }
	  }*/
	 
	  public function logout() {
	    unset($_SESSION['user_id']);
	    unset($this->user_id);
	    unset($_SESSION['admin_id']);
	    unset($this->admin_id);
	    $this->logged_in = false;	
	    $this->admin_logged_in  = false;	    
	    }
		 
	public function is_logged_in() {
		return $this->logged_in;
	 }	 
	public function is_admin_logged_in() {
		return $this->admin_logged_in;
	 }
	
	public function message($msg="") {
	  if(!empty($msg)) {
	    // then this is  "set message"
	    // make sure you understand why $this->message=$msg wouldn't work
	    $_SESSION['message'] = $msg;
	  } else {
	    // then this is "get message"
	    return $this->message;
	  }
	}
	
	private function check_login() {
	  if(isset($_SESSION['user_id'])) {
	  	$this->user_id = $_SESSION['user_id'];
	  	$this->logged_in = true;
            } elseif(isset($_SESSION['admin_id'])) {
	  	$this->admin_id = $_SESSION['admin_id'];
	  	$this->admin_logged_in = true;
            }else {
	    unset($this->user_id);
	    unset($this->admin_id);
	    $this->logged_in = false;
	    $this->admin_logged_in = false;
	   }
	
	}
	
	private function check_admin_login() {
	  if(isset($_SESSION['admin_id'])) {
	  	$this->admin_id = $_SESSION['admin_id'];
	  	$this->logged_in = true;
	  } else {
	    unset($this->admin_id);
	    $this->admin_logged_in  = false;
	   }
	
	}
	
	private function check_message() {
	  // Is there a message stored in the session
	  if(isset($_SESSION['message'])) {
	    // Add it as an attribute anderase the stored version
	   $this->message = $_SESSION['message'];
	   unset($_SESSION['message']);
	   } else {
	 $this->message = "";
	}
	   }
	   }

$session1 = new Session1();
$message = $session1->message();


?>