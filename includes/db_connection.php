<?php 
defined("DB_SERVER") ? null : define("DB_SERVER","localhost");
defined("DB_USER") ? null : define("DB_USER", "widget_cms");
defined("DB_PASS") ? null : define("DB_PASS", "secretpassword");
defined("DB_NAME") ? null : define("DB_NAME", "photo_gallery");
 
 ///Create a database connection
 $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
 
 ///Test if connection succeeded
 if(mysqli_connect_error()){
 	die("The database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");}

?>
