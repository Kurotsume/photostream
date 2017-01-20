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
  	public $errors=array();
        

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
        
        public static function find_userfolder_by_id($id, $user_id){
           $folder_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id=" . $id . " AND user_id=" . $user_id . " LIMIT 1");
        return !empty($folder_array) ? array_shift($folder_array) : false;
        }
        
        public function destroy(){
	  // First remove the database entry
            if($this->delete()) {
                $photos = Photograph::find_userphotos_by_foldername($this->foldername,$this->user_id);
                
                foreach($photos as $photo){
                    $photo->delete();
                }
                // then remove the file
                $target_path = 'images' . DS . $this->location;
	  		
                if($this->recursiveRemoveDirectory($target_path)){
                    return true; 
                } else {
                    // database delete failed
                    return false;
                }
                
            } else{
                return false;
            }
	}
	
	private function recursiveRemoveDirectory($directory){
	
            foreach(glob("{$directory}/*") as $file){
            
                if(is_dir($file)) { 
                //maybe log files being removed from directory
                    $this->recursiveRemoveDirectory($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($directory);
        }
        
        public function dir_update() {
            global $database;
            
            if($old_folder = static::find_userfolder_by_id($this->id, $this->user_id)){
                $oldname = 'images' . DS . $old_folder->location;
                $newname = 'images' . DS . $this->user_id . DS . $this->foldername;
                
                if(rename($oldname,$newname)){
                    //renamed the dir
                    if($photos = Photograph::find_users_folders($this->user_id,$old_folder->foldername)){
                    
                        foreach($photos as $photo){
                            $photo->location = "images" . DS . $this->user_id . DS .  $this->foldername . DS . $photo->filename;
                            $photo->folder = $this->foldername;
                            $photo->save();
                        }
                        
                    }else{
                        ///Do nothing
                    }
                    
                }else{
                    $this->errors[] = "Couldn't rename the folder in database.";
                    return false;                
                }
                
            }else{
                $this->errors[] = "Couldn't find current folder in database.";
                return false;
            }
            
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
            if($database->affected_rows() == 1){
                return true;
            }else{
                if(rename($newname,$oldname)){
                    $this->errors[] = "Couldn't rename the folder in database.";
                    return false;
                }else{
                    Logger::log_action("Folder Rename Error", "Error renaming file for User: " . $this->user_id . ". The tried to rename folder " . $newname . " back to " . $oldname . " and it failed. " . $newname . "must be updated to " . $oldname . ".");
                    $this->errors[] = "Couldn't rename the folder in database.";
                    return false;                
                }
            }
	
	
	/*
	$sql .= "username='" . $database->escape_value($this->username) . "', ";
	$sql .= "password='" . $database->escape_value($this->password) . "', ";
	$sql .= "first_name='" . $database->escape_value($this->first_name) . "', ";
	$sql .= "last_name='" . $database->escape_value($this->last_name) . "' ";
	*/
	
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