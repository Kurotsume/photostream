<?php
require_once(LIB_PATH.DS."functions.php");
require_once("database.php");

class folder extends DatabaseObject {
    
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
        
        public static function find_by_sql($sql="") {
	  	global $database;
	  	$result_set = $database->query($sql);
	  	$object_array = array();
	  	while($row = $database->fetch_array($result_set)){
		  	$object_array[] = static::instantiate($row);
		  }
		return $object_array;
	  }
	  
        private static function instantiate($record) {
	   $class_name = get_called_class();
	   $object = new $class_name;
	   	   
	   foreach($record as $attribute=>$value){
	   
	    	 if($object->has_attribute($attribute)){ 
	    	 $object->$attribute = $value;
	 	} 
	 }  	   
	   return $object;
        }
        
        private function has_attribute($attribute){
	  //get_object_vars returns an associative array with all attributes
	  //(including private ones as the keys and their current values as the value.
	 $object_vars = $this->attributes();
	 // We don't care about the value, we just want to knowifthe key array_key_exists
	 // Will return true or false	
	 return array_key_exists($attribute, $object_vars);
	}
	
        protected function attributes() {
	  // return an array of attribute keys and their values
	  $attributes = array();	  
	  foreach(static::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	   
        /*
	public static function find_all(){
		global $database;
	  return static::find_by_sql("SELECT * FROM ".  static::$table_name .";"); 
	}
	
	public static function find_by_id($id=0) {
	  	global $database;
	 	 $user_array = static::find_by_sql("SELECT * FROM ". static::$table_name ." WHERE id=".$id." LIMIT 1");
	 	 return !empty($user_array) ? array_shift($user_array) : false;
	  
	  }
	  */ /*  	
  		
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key=> $value) {
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}

	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();	
	}	
	
	*/
        public function create() {
      	global $database;
      	// DOn't forget your SQL syntax and good habits:
      	// - INSERT INTO table (key, key) VALUES ('value', 'value')
      	// - single-qoutes around all values
      	// - escape all values to prevent SQL injection
      	
      	
      	$class_attribs = $this->sanitized_attributes();
            //$num_of_attribs = count($class_attribs);
            
        ///A second check maybe remove   
      	if(!Folder::find_by_foldername($class_attribs['foldername'],$this->user_id)){

                            
            $sql = "INSERT INTO " . static::$table_name . " (";
            $sql .= join(", ", array_keys($class_attribs));
            $sql .= ") VALUES ('";
            $sql .= join("', '", array_values($class_attribs));
            $sql .= "')";
            
            $sql = str_replace("'',", "NULL,", $sql);            
                    
            if($database->query($sql)) {
                $this->id = $database->insert_id();
echo FOLDER_PATH . DS . $this->id . DS . $class_attribs['foldername'];
                if(mkdir(FOLDER_PATH . DS . $this->id . DS . $class_attribs['foldername'])){
                    $this->location = FOLDER_PATH . DS . $this->id . DS . $class_attribs['foldername'];
                    $message = "Folder created.";
                    return true;
                    
                } else {
                    $delfolder = Folder::find_by_id($this->id);
                    $delfolder->delete();
                    $message = "Couldn't make the folder in system";
                    return false;
                }	
            } else {
                return false;
            }
        } else { ///A second check maybe remove
                $message = "A folder with that name already exists on server.";
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
	
	$oldfolder = Folder::find_by_sql($this->id);
	
            //rename folder directory name on server to new one
            if (rename(FOLDER_PATH . DS . $oldfolder->location, FOLDER_PATH . DS . $this->location)) {                 
                
                foreach($attributes as $key=> $value) {
                    $attribute_pairs[] = "{$key}='{$value}'";
                }
                
                $sql = "UPDATE " . static::$table_name . " SET ";
                $sql .= join(", ", $attribute_pairs); 
                $sql .= " WHERE id=" . $this->id;
                $database->query($sql);
                return ($database->affected_rows() == 1)? true: false;
                
                
            } else {
                $message = "Couldn't rename the folder in system.";
                return false;          
            }
	
	}
	
        
	
	/*
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