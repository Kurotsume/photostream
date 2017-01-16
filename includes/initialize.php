<?php 
//Define the core paths
//Define them as absolute paths to make sure that require_once works as expected

//DIRECTORY_SEPARATOR is a PHP pre-defined constant
//(\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ?  null : define('SITE_ROOT', DS . 'var' .  DS . 'www' . DS . 'ExerciseFiles' . DS . 'Chapter_15' . DS . '15_03' . DS . 'Photo_Gallery');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT . DS . 'includes'); 

defined('FOLDER_PATH') ? null : define('FOLDER_PATH', SITE_ROOT . DS . 'public' . DS . 'images');  

defined('ICON_PATH') ? null : define('ICON_PATH', FOLDER_PATH . DS . 'icons'); 
 
// load config file first
require_once(LIB_PATH . DS . 'config.php');

//load basic functions next so that everything after can use them
require_once(LIB_PATH.DS. 'functions.php');

// load core objects
require_once(LIB_PATH.DS.'session1.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH. DS.'database_object.php');
require_once(LIB_PATH. DS . 'pagination.php');
require_once(LIB_PATH. DS . 'PHPMailer-master' . DS . 'class.phpmailer.php');
require_once(LIB_PATH. DS . 'PHPMailer-master' . DS . 'class.smtp.php');
require_once(LIB_PATH. DS . 'PHPMailer-master' . DS . 'class.phpmaileroauth.php');
require_once(LIB_PATH. DS . 'actionlog.php');
require_once(LIB_PATH. DS . 'mailman.php');
require_once(LIB_PATH. DS . 'validation_functions.php');

// load database-related classes
require_once(LIB_PATH.DS.'user1.php');
require_once(LIB_PATH.DS.'photograph.php');
   
//require_once("config.php");
//require_once("functions.php");
//require_once("session.php");
//require_once("database.php");
//require_once("user.php");

?>
