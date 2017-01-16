<?php


class Logger {

public static $dir="/var/www/ExerciseFiles/Chapter_15/15_03/Photo_Gallery/logs/log.txt"; // LIB_PATH;"."; 

	function __construct() {
	  
	  }

	public static function log_action($action, $statement="") {
	  
	  	if(!file_exists(static::$dir)) {
		  
		  fopen(static::$dir,'a');
		 
		 } 
		else {
		   //Do nothing
		  }
	  		 
		 	if(is_writable(static::$dir)) {
			  //$message = "Log file is writable.";
			 //echo $message;
			if( $handle =  fopen(static::$dir,'a')) {
				fwrite($handle, date("Y-m-d H:i:s" ) . " | " . $action . ": " . $statement ."\n");
			}
			  }
			else {
			  $message = "Log file is not writable.";
			  // redirect_to()
			  echo $message;
			  }
	    
	    	
	  }
	
	public static function log_list() {
	  if(file_exists(static::$dir)) {
	    if(is_readable(static::$dir)) {
    		if( $handle = fopen(static::$dir, 'r')) {
		  $content = "";
		  while(!feof($handle)) {
		    $content .= fgets($handle);
		  }		  
		  fclose($handle);
		  echo nl2br($content);
    		} else {
		  echo "Log file can't be parsed!";
    		}// End end fopen
	    } else {
	      echo "Log file is not readable!";
	    } //End if is_readable
	  } else {
	    echo "Log file does not exist!";
	  } //End if file exists
  
	}
	  
	  
	public static function clear_log($action, $statement) {
	  if(file_exists(static::$dir)){
	    if(is_readable(static::$dir)) {
	      if($handle = fopen(static::$dir, "w")) {
		fwrite($handle, $action . " on " . date("Y-m-d | H:i:s") . " by User ID " . $statement . ".\n");
	 	fclose($handle);
	      } //end $handle 
	      else {
		echo "Log file can't overwritten!";
	      }// End end fopen
	    }else {
	      echo "The file is not readable!";
	    }// end if is readable
	  }else {
	    echo "Log file does not exist!";
	  }// end if file exists

	} // end function
	  
} // end Class
	  
	  
//$Logger = New Logger;
//$logger ->log_action("Run","HI shiter")

?>