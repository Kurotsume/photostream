<?php 
require_once(LIB_PATH.DS."config.php");

class MySQLDatabase {

   private $connection;
   public $last_query;
   private $magic_quotes_active;
   private $real_escape_string_exists;
   
   function __construct(){
   		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
   		$this->real_escape_string_exists = function_exists("mysqil_real_escape_string");
   }  
	 
   public function open_connection() {
	  $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
	  
	  		if(!$this->connection) {
	  			die("Database connection failed1: " . mysqli_error());
	  		}
			else {
				$db_select = mysqli_select_db($this->connection, DB_NAME);
			
				if (!$db_select) {
			   	 	die("Database selection failed2: " . mysqli_error());
				}
			}
   }    
   
   
  public function mysql_prep($string) {
	$escaped_string = mysqli_real_escape_string($this->connection, $string);
	return $escaped_string;
    
    }
   
   public function query($sql) {
      $this->last_query = $sql;
   	  $result = mysqli_query($this->connection, $sql);
	  $this->confirm_query($result);
	  return $result;   
   }

   public function escape_value($value) {
		if($this->real_escape_string_exists){	
			if($this->magic_quotes_active){ 
			   $value = stripslashes($value);
			}
			else {
				 $value = mysqli_real_escape_string($value);
			}
		} 
		else {
			 if(!$this->magic_quotes_active) { 
			 	$value = addslashes($value );
			 }
		}
	return $value;
	}
	
// "Database neutral" functions 
   
   
   function attempt_login($username, $password){
	$target = find_admin_by_username($username);
	if ($target) {
	   if (password_check($password, $target["password"])){
	   	  return $target;
	   }
	   else {
		 return false;
	   }
	}
	else {
		 return false;
	}    
    }

    function password_check($password, $existing_hash){
        //existing hash contains format and salt at start
    // $hash = crypt($password, $existing_hash);
        //if ($hash === $existing_hash){
        if($password === $existing_hash){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }	
            
    function find_target_by_username($username){
    global $connection;

    $safe_target = mysqli_real_escape_string($connection, $username);

    $query = "SELECT * ";
    $query .= "FROM ";
    $query .= $static::table_name;
    $query .= " WHERE username = '{$safe_target}' ";
    $query .= "LIMIT 1";

    $username_set = mysqli_query($connection, $query);

    //confirm_query($username_set);
                    if ($username = mysqli_fetch_assoc($username_set)) {
            return $username;
            } 
            else {
                    return null;
            }

    return $username;
    }

   public function fetch_array($result_set){	
   		  return mysqli_fetch_array($result_set);
   }
  
   public function num_rows($result_set){
		   return mysqli_num_rows($result_set);
	}
	
   public function insert_id(){
     // get the las id inserted over the
		   return mysqli_insert_id($this->connection);
	}
	
   public function affected_rows(){
		return mysqli_affected_rows($this->connection);   
	}   
	  
   private function confirm_query($result) {
   	   if(!$result) {
	      die("The database query failed<br />" . mysqli_error($this->connection) . "<br /> The last query sent:<br />" . $this->last_query);
	   }
   } 
	   
   public function close_connection() {
   		  if(isset($this->connection)){
		  		mysqli_close($this->connection);
				unset($this->connection);
		  }
   }
		  
}

$database = New MySQLDatabase();
$db =& $database;
?>
