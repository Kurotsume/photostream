<?php

require_once(LIB_PATH.DS."functions.php");
require_once("database.php");
//require_once('../../includes/session1.php');

class Admin extends DatabaseObject {
 
 	protected static $table_name="admins";
 	protected static $db_feilds = array('id', 'username', 'password', 'first_name', 'last_name');
 	
  	public $id;
  	public $username;
  	public $password;
  	public $first_name;
  	public $last_name;
  	
  	
  	
  	public function full_name(){
	  if(isset($this->first_name) && isset($this->last_name)) {
	    return $this->first_name . " " . $this->last_name;
	    } else {return "";
	     }
	}
  	
	public static function authenticate($username="", $password="") {
	  global $database;
	  $username = $database->escape_value($username);
	  $password = $database->escape_value($password);
	  $sql = "SELECT * FROM ".  self::$table_name . " ";
	  $sql .= "WHERE username = '{$username}' ";
	  $sql .= "AND password = '{$password}' ";
	  $sql .= "LIMIT 1";
	  $user_array = self::find_by_sql($sql); //HERE
	  return !empty($user_array) ? array_shift($user_array) : false;
	  
	}
      
/*
      	public static function find_all(){}
	
	public static function find_by_id($id=0) {}
  	
  	public static function find_by_sql($sql="") {}
	  
	 private static function instantiate($record) {}
	
	private function has_attribute($attribute){}
*/

}

?>