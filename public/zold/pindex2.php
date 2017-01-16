<?php 
require_once("../includes/initialize.php");
include_layout_template("header.php");


$user = User::find_by_id(1);
echo $user->full_name();

echo "<br />";
echo "<br />";

echo "<hr />";

echo "<br />";

$users = User::find_all();
foreach($users as $user){
echo "User: " . $user->username . "<br />";
echo "Name: " . $user->full_name() . "<br />";
}


include_layout_template("footer.php");
?>
