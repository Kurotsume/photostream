<?php

require_once(LIB_PATH.DS."functions.php");
require_once("database.php");
//require_once('../../includes/session1.php');

class Photograph extends DatabaseObject {
 
 	protected static $table_name="photographs";
 	protected static $db_feilds = array('id', 'filename', 'type', 'size', 'caption','location','private','folder', 'owner');
 	
  	public $id;
  	public $filename;
  	public $type;
  	public $size;
  	public $caption;
  	public $location;
  	public $private;
  	public $folder;
  	public $owner;
  	
  	private $target_path;
  	private $temp_path;
  	protected $upload_dir = "images";
  	public $errors=array();
  	
  	protected $upload_errors = array(
		UPLOAD_ERR_OK => "No errors.",
		UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
		UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
		UPLOAD_ERR_PARTIAL => "Partial upload.",
		UPLOAD_ERR_NO_FILE => "No temporary directory.",
		UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
		UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
		UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
		);
	
	// Pass in $_FILE(['uploaded_file'])
	public function attach_file($file) {
	  //Perfom error checking on the form parameters
	  if(!$file || empty($file) || !is_array($file)) {
	    // error: nothing uploadedor wrong argument usage
	    $this->errors[] = "No file was uploaded.";
	    return false;
	  } elseif($file['error'] != 0) {
	    // error report what PHP says went wrong
	    $this->errors[] = $this->upload_errors[$file['error']];
	    return false;
	  } else {
	    
	    // Set object attributes to the form parameters.
	    $this->temp_path = $file['tmp_name'];
	    $this->filename = basename($file['name']);
	    $this->type = $file['type'];
	    $this->size = $file['size'];
	    // Don't worry about saving anything to the database yet.	
	    return true;
	  }
	}
	
	public function set_path($imgpath){
            $this->target_path=$imgpath;
	}
	
	public function get_path(){
            $imgpath = $this->target_path;
            
            return $imgpath;
	}
		     
	public function photo_save() {
	  // A new record won't have an id yet.
	    	//echo "Hi0";
	  if(isset($this->id)) {
	    $this->update();
	  } else {
	    // Make sure there are no errors
	    
	    //Can't save if there are pre-existing errors
	    if(!empty($this->errors)) { return false;}
	    
	    //Make sure the caption is not too long for the DV
	    if(strlen($this->caption) >= 255) {
	      $this->errors[] = "The caption can only be 255 characters long.";
	      return false;
	    }
	    
	    //Determine the $target_path
	    if($this->target_path==""){
                $this->target_path = SITE_ROOT . DS . 'public' . DS . $this->upload_dir . DS . $this->filename;
	    }
	    
	    //Make sure a file doesn't already exist in the target location
	    if(file_exists($this->target_path)) {
	      	$this->errors[] = "The file {$this->filename} already exists in {$this->target_path}";
	      	return false;
	    }
	    
	    // Attempt to move the file
	    if(move_uploaded_file($this->temp_path, $this->target_path)) {
	    	// Saveacorresponding entry to the database
	    	if($this->create()) {
	    	unset($this->temp_path);
	    	return true;
	    	} 
	     } else {
	      // Fail
	      $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the uploader folder.";
	      return false;
	     }
	  }
	}
	
	public function size_as_text(){
	  	if($this->size < 1024){
		  return  $this->size  . " bytes";
		} elseif ($this->size < 1048576) {
		  $size_kb = round($this->size/1024);
		  return "{$size_kb} KB";
		} else {
		  $size_mb = round($this->size/1048576, 1);
		  return "{$size_mb} MB";
		}
	 }
      
      //Common Database Methods
	public static function find_all(){
		global $database;
	  return static::find_by_sql("SELECT * FROM ".  static::$table_name .";"); 
	}
	
	public static function find_by_id($id=0) {
	  	global $database;
	 	 $user_array = static::find_by_sql("SELECT * FROM ". static::$table_name ." WHERE id=". $id ." LIMIT 1");
	 	 return !empty($user_array) ? array_shift($user_array) : false;
	  
	  }
	  
	public static function find_users_folders($uid=0,$foldername) {
	  	global $database;
	 	 $user_array = static::find_by_sql("SELECT * FROM ". static::$table_name ." WHERE owner=" . $uid . " AND folder=" . $foldername." LIMIT 1");
	 	 return !empty($user_array) ? array_shift($user_array) : false;
	  
	  }	  
	  
	public function comments(){
	  return Comment::find_comments_on($this->id);
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
	
	/*public static function count_all() {
	 $global $database;
	 $sql ="SELECT COUNT(*) FROM". self::table_name . ";"
	 $result_set =$database->query($sql );
	 $row = mysqli_fetch_array($result_set);
	 return array_shift($row);
	 
	 
	 	 	 
	 }*/
	  
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
	public function image_path() {
	 // return $this->upload_dir . DS . $this->filename;
	  return $this->location;
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
	  foreach(static::$db_feilds as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
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
	
	public function destroy() {
	  // First remove the database entry
	  	if($this->delete()) {
	  		// then remove the file
	  		$target_path = SITE_ROOT . DS . 'public' . DS . $this->location;
	  		return unlink($target_path) ? true : false;
	  	} else {
		  	// database delete failed
			return false;
		}
	}
	  
	
	public function create() {
      	global $database;
      	// DOn't forget your SQL syntax and good habits:
      	// - INSERT INTO table (key, key) VALUES ('value', 'value')
      	// - single-qoutes around all values
      	// - escape all values to prevent SQL injection
      	
      	$class_attribs =$this->sanitized_attributes();
      	$num_of_attribs = count($class_attribs);
      	    	
      	$sql = "INSERT INTO " . static::$table_name . " (";
      	$sql .= join(", ", array_keys($class_attribs));
      	$sql .= ") VALUES ('";
      	$sql .= join("', '", array_values($class_attribs));
      	$sql .= "')";
      	
      	$sql = str_replace("'',", "NULL,", $sql);
      	
      	//$i = 1;      
      	/*foreach($class_attribs as $attribute=>$value) {
	  if($i < $num_of_attribs) {
	    $sql .= $database->escape_value($this->$attribute) . "', '";
	   // echo "Hi" . $attribute;
	  }else {
	    $sql .= $database->escape_value($this->$attribute) . "')";
	    //echo "Hi2" . $attribute;
	  }
	}*/
	  
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
      
	public function delete() {
	global $database;
	// Don't forget your SQL syntax and good habits:
	// - DELETE FROM table WHERE condition LIMIT 1
	// escape all values to prevent SQL injection.
	// LIMIT 1
	$sql = "DELETE FROM " . static::$table_name . " WHERE id=";
	$sql .= $this->id;
	$sql .= " LIMIT 1";
	$database->query($sql);
	return ($database->affected_rows() == 1)  ? true : false;	
	
      }
    
  	

}

?>