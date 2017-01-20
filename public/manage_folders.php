<?php

require_once('../includes/initialize.php');

if(!$session1->is_logged_in()) {
 redirect_to("user_login.php");
}


$users_folders = Folder::find_all_from_userid($session1->user_id);


?>


<?php include_layout_template("header2.php"); ?>

<h2>Manage Folders</h2>


<a href="user_home.php">&laquo; Back</a><br />

<?php

if($users_folders){
echo '<table id="nofoldersforbar">';

echo '<tr id=""><th id="thfolderbar">Folder</th><th id="thfolderbar">Folder Name</th><th id="thfolderbar">Folder Options</th><th id="folderbar">Folder link</th></tr>';


foreach($users_folders as $folder){
echo '<tr id="tablefolderbar"><td id="folderimage"><a href="edit_folder.php?id='. $folder->id . '"><img id="folderimage" src="../public/images/icons/folderpic.png" class="img-responsive"></td></a>';
echo'<td id="tablefolderbar">' . ucfirst($folder->foldername) . '</td>';
echo'<td id="tablefolderbar"><a href="edit_folder.php?id='. $folder->id . '"> Edit</a> / <a href="delete_folder.php?id='. $folder->id . '">Delete</a></td>';
echo '<td id="tablefolderbar"> ' . FOLDER_PATH . DS . ucfirst($folder->location) . '</td></tr>';

}

echo '</table></br></br>';

}else {echo '<table id="nofoldersforbar"><tr><td><h2>No folders exist.</h2></td></tr></table>';}

?>


<table id="tablefolderbar">
<tr id="tablefolderbar"><th id="tablefolderbar"  colspan="3">Create New Folder</th></tr>
<tr id="tablefolderbar"><td id="folderimage"><img id="folderimage" src="../public/images/icons/folderpic.png" class="img-responsive"></td><td id="folderbar">Name</br><input type="text" name="createfolder" value=""></td><td id="folderbar"><input type="submit" name="submitnewfolder"></td>
</table>
   





<?php include_layout_template("footer2.php"); ?>