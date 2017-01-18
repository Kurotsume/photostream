<?php

function strip_zeros_from_date( $marked_string="") {
    // remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}//strip_zeros_from_date();



function redirect_to($location = NULL ){
	if($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}//function redirect_to();


function output_message($message="") {
	if(!empty($message)) {
		 return '<p class="message">'. $message . "</p>";
	} else{
	  	return "";		  
	}
}

function __autoload($class_name) {
$class_name = strtolower($class_name);
$path = LIB_PATH.DS."{$class_name}.php";
	  if(file_exists($path)) { 
	  		require_once($path);	
	  }
	  else {
	  	    die("The file {$class_name}.php could not be found");	
	  }		   
}// function __autoload();

function include_layout_template($template=""){
		 include(SITE_ROOT . DS . 'public' . DS . 'layouts' . DS . $template);
}//End include_layout_template();


function logged_in() {
	return isset($_SESSION['admin_id']);
}

function form_errors($errors="") {
  foreach($errors as  $error => $value) {
  	echo $value. "<br>";
  	}
  
}


	
function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);  
}

function filereader($file) {
 	$file_log = "";
  	if (file_exists($file)) {
		if (is_readable($file)){
	  		if($handle = fopen($file, 'r'))  { // read
				$content = fread($handle, filesize($file));
				$file_log = '<p id="logfile">' . nl2br($content) . '</p>';
			} // end if ($handle)
			else {
		  		$file_log = "Log file open failed";
			} //end else($handle)
	  	} //end if (is_readable)
		else {
	  		$file_log = "Log file is not readable!";
	  	} //end else (is_readable)
	}//end if (file_exists($file))
	else {
  		$file_log = "Log file does not exist!";
	}//end else (file_exists($file))
	
	return $file_log;
}
/*    
function log_action($action, $message="") {
  
  $message = date_format(date_create(), 'Y-m-d H:i:s') . " | " . $message . "\n";
  $file = LIB_PATH . DS . "log.txt";
  
  
  if (file_exists($file))  {
    	if(is_writable($file)) {
		 if($handle =  fopen($file, 'a')) {
		   	fwrite($handle, $message); // 
		 
		 	fclose($handle);
	  	}
		 else {
		 	echo "Could not open the file for writing man!";  
		 }// end $handle =  fopen($file, 'a'))
	} else {
		 echo("Log file is not writable.");
	}// end if is writable
  }   
	
}
*/	

function log_action($action, $message="") {



}

function is_session_started()
{
global $session1;

    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return $session1->is_logged_in();
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}


function picture_loader(){
global $session1;

if(isset($_POST['submit'])) {
  $photo = new Photograph();
  $photo->caption = $database->escape_value(trim($_POST['caption']));
  $photo->private =  $database->escape_value(trim($_POST['sharephoto']));
  $photo->owner = $session1->user_id;
  $errors = "";
  ///var/www/ExerciseFiles/Chapter_15/15_03/Photo_Gallery/public/trim($_POST['selectfolder'])
 
  
  $photo->attach_file($_FILES['file_upload']);
  
   if(trim($_POST['selectfolder']) <> "Make new box"){
    $selectfolder = $database->escape_value(trim($_POST['selectfolder']));
    $photo->set_path("images" . DS . $session1->user_id . DS . $selectfolder .  DS . $photo->filename);
    $photo->folder = $selectfolder;
    
    
    /////
    
    $photo->location = $photo->get_path();
  
    if($photo->photo_save()) {
        //Success
        $session1->message( "Photograph upload successfully.");
        redirect_to('photo_upload.php');
    } else {
        //Failure
        $message = join("<br />", $photo->errors);
    } 
    
    /////
    
    } else {
    
    //if user id folder does not exist already create the folder
        if(!file_exists("images". DS . $session1->user_id)){
        
            if(!mkdir("images". DS . $session1->user_id)){
                $errors= true;
            }
            
        }
    
        if(!$errors){
            //then if named folder does not exist already create the folder
            $foldernamebox = $database->escape_value(trim($_POST['foldernamebox']));
            if(!file_exists("images". DS . $session1->user_id . DS . $foldernamebox)){
                if(!mkdir("images". DS . $session1->user_id . DS . $foldernamebox)){
                    $errors = true;
                    $session1->message("Error saving user folder in database folder could not be created!");
                }
            } 
                
            if(!$errors){ 
                $newfolder = New Folder();
                $newfolder->user_id =$session1->user_id;
                $newfolder->foldername = $foldernamebox;
                $newfolder->location = $session1->user_id . DS . $foldernamebox;
                $newfolder->size = 4;
                if($newfolder->save()){
                }else{ 
                    rmdir("images". DS . $session1->user_id . DS . $foldernamebox);
                    $session1->message("Error saving category folder in database folder could not be created!");
                    $errors = true;
                }
            } //if(!$errors)
            
            if(!$errors){    
                //then set the target location
                $photo->set_path("images". DS . $session1->user_id . DS . $foldernamebox .  DS . $photo->filename);
                $photo->folder = $foldernamebox;
                $photo->location = $photo->get_path();
            
                if($photo->photo_save()) {
                    //Success
                    $session1->message( "Photograph upload successfully.");
                    redirect_to('photo_upload.php');
                } else {
                    //Failure
                    $message = join("<br />", $photo->errors);
                        echo "Can't save photo!";
                } 
            
            }
            
        }
    }

}
}


function picture_form(){
$max_file_size = 1048576;
global $session1;

$html = "";
	$html .= <<<HTML
	<script>
	function makefolder(){
	if(document.getElementById("selectfolder").value == "Make new box"){
	document.getElementById("foldernamebox").disabled = false;
	}else{
	document.getElementById("foldernamebox").disabled = true;
	document.getElementById("foldernamebox").value = "";
	}
	}
	</script>
HTML;
	
	
	$folderarray = Folder::find_all_from_userid($session1->user_id);

	
	$html .= <<<HTML
	<form action="" enctype="multipart/form-data" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="{$max_file_size}" />
		<p>Select file to upload: <input type="file" name="file_upload" /></p>
		<p>Add caption to image:<input type="text" name="caption" value="" /></p>		
		
		Make image visible to public?: <select name="sharephoto">
                    <option id="Show to public" value="0">Yes</option>
                    <option id="Hide to public" value="1">No</option>
		</select><br /><br />
		
		Upload to folder: <select name="selectfolder" id="selectfolder" onclick="makefolder()">
HTML;
	echo $html;					

		if($folderarray){		
                    foreach($folderarray as $folder):
                    echo "<option id=\"" . htmlentities($folder->foldername) . "\" value=\"" . htmlentities($folder->foldername) . "\">" . htmlentities(ucfirst($folder->foldername)) ."</option>";
                    
                    endforeach;
                }
	$html = <<<HTML
                <option id="Make new box" value="Make new box">Create new folder</option>
		</select><br /><br />
		
		<p>Name new folder:<input id="foldernamebox" type="text" name="foldernamebox" value="" disabled="true" /></p>
		
		
		
		<input type="submit" name="submit" value="Upload" />
	</form>
HTML;
	
echo $html;

}

// Make sure file exists or else create new file $
//Make sure file is writable or else output an error $
// Append new logs to EoF $
//Entries look like  $
//// 2009-01-01 13:10:03 | Login: kskoglund logged in. $
// Remember: SITE_ROOT andoubl DS $
// Consider how to handle new lines (de quotes matter) $
// Use log_action() in photo_gallery/public/admin/login.php $

//Like all admin pages, confirm user is logged in $
//Locate logs/log.txt using SITE_ROOT and DS 
//IF file does not exist or is not readable, output an error 
//If file exists, read it's contents (your choice how)
//Output the entries to HTML (nl2br, CSS, table)
//Add ling "Clear log file" that requests "logfile.php?clear=true"
//Add code to clear the file:
//if($_GET['clear']=='true') {.....}
// Log the fact that the log was cleared