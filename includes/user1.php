<?php

require_once(LIB_PATH.DS."functions.php");
require_once("database.php");
//require_once('../../includes/session1.php');

class User extends DatabaseObject {
 
 	protected static $table_name="users";
 	protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'user_role', 'email');
 	
  	public $id;
  	public $username;
  	public $password;
  	public $first_name;
  	public $last_name;
  	public $user_role;
  	public $email;
  	
  	
  	
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
              
        public static function create_post_user($username, $password, $first_name, $last_name, $user_role, $email) {
            global $database;
            
            $new_user = New User;
            
            $new_user->id = NULL;
            $new_user->username = $username;
            $new_user->password = $password;
            $new_user->first_name = $first_name;
            $new_user->last_name = $last_name;
            $new_user->user_role = $user_role;
            $new_user->email = $email;
            
            $new_user->create();            
        
        }
        
        public static function count_all_admins() {
	 global $database;
	 $sql ="SELECT COUNT(*) FROM ". static::$table_name . " WHERE user_role=1;";
	 $result_set =$database->query($sql );
	 $row = $database->fetch_array($result_set);
	 $row_value = array_shift($row);
	 return $row_value;
	 }
	 
	 	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();	
	}	
	
      public function create() {
      	global $database;
      	// DOn't forget your SQL syntax and good habits:
      	// - INSERT INTO table (key, key) VALUES ('value', 'value')
      	// - single-qoutes around all values
      	// - escape all values to prevent SQL injection
      	
      	$class_attribs = $this->sanitized_attributes();
      	//$num_of_attribs = count($class_attribs);
      	      	    	
      	$sql = "INSERT INTO " . static::$table_name . " (";
      	$sql .= join(", ", array_keys($class_attribs));
      	$sql .= ") VALUES ('";
      	$sql .= join("', '", array_values($class_attribs));
      	$sql .= "')";
      	
      	$sql = str_replace("'',", "NULL,", $sql);
      	
      		  
      	if($database->query($sql)) {
	  $this->id = $database->insert_id();
	  return true;      	
      	} else {
	  return false;
      	} 
      	
      }
      
      
      protected function update() {
	global $database;
	// Don't forget your SQL syntax and good habits:
	// - UPDATE table SET key='value', key'value' WHERE condition
	// - single-quotesaround all values
	// escape all values to prevent SQL injection.
	$attributes = $this->sanitized_attributes();
	$attribute_pairs = array();
	foreach($attributes as $key=> $value) {
	  $attribute_pairs[] = "{$key}='{$value}'";
	}
	$sql = "UPDATE " . static::$table_name . " SET ";
	$sql .= join(", ", $attribute_pairs); 
	$sql .= " WHERE id=" . $this->id;
	$database->query($sql);
	return ($database->affected_rows() == 1)? true: false;
	
	
	/*
	$sql .= "username='" . $database->escape_value($this->username) . "', ";
	$sql .= "password='" . $database->escape_value($this->password) . "', ";
	$sql .= "first_name='" . $database->escape_value($this->first_name) . "', ";
	$sql .= "last_name='" . $database->escape_value($this->last_name) . "' ";
	*/
	
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