<?php
require_once(LIB_PATH.DS."functions.php");
require_once("database.php");

class Folder extends DatabaseObject {
    
        protected static $table_name = "folders";
        protected static $db_fields = array('id', 'user_id','foldername','location','size');
        
        public $id;
        public $user_id;
        public $foldername;
        public $location;
        public $size;
        

        public static function find_by_foldername($foldername="", $uid) {
            global $database;
            $folder_array = static::find_by_sql("SELECT * FROM ". static::$table_name ." WHERE foldername='" . $foldername ."' AND user_id='" . $uid . "' LIMIT 1");
        return !empty($folder_array) ? array_shift($folder_array) : false;	  
        }        
        
        public static function find_all_from_userid($uid=0) {
	  	global $database;
	 	 $user_array = static::find_by_sql("SELECT * FROM ". static::$table_name ." WHERE user_id=".$uid);	 	 
	 	 
	 	 return !empty($user_array) ? $user_array : false;
	  
        }
        
       
	
        
	
	/*
	$sql .= "username='" . $database->escape_value($this->username) . "', ";
	$sql .= "password='" . $database->escape_value($this->password) . "', ";
	$sql .= "first_name='" . $database->escape_value($this->first_name) . "', ";
	$sql .= "last_name='" . $database->escape_value($this->last_name) . "' ";
	*/
	/*
      }
	
	public static function count_all() {
	 global $database;
	 $sql ="SELECT COUNT(*) FROM ". static::$table_name . ";";
	 $result_set =$database->query($sql );
	 $row = $database->fetch_array($result_set);
	 $row_value = array_shift($row);
	 return $row_value;
	 }
      
        public function delete() {
	global $database;
	// Don't forget your SQL syntax and good habits:
	// - DELETE FROM table WHERE condition LIMIT 1
	// escape all values to prevent SQL injection.
	// LIMIT 1
	$sql = "DELETE FROM " . static::$table_name . " WHERE id=";
	$sql .= $database->escape_value($this->id);
	$sql .= " LIMIT 1";
	$database->query($sql);
	return ($database->affected_rows() == 1)  ? true : false;	
	
      }*/
    
    
    
    
    
    
    

        
    
    
}

?>