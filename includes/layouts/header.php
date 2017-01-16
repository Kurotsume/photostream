<?php 
$layout_context = "admin";
if (!isset($layout_contex)){
   $layout_context = "public";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
   
<html lang="en">
	<head>
		<title>Raccon City Information Center<?php if ($layout_context == "admin"){ echo "Admin";}?></title>
		<link href="css/public.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
	
	<div id="header">
	<a style="display:block" href="http://mysite.local/Exercise%20Files/Chapter%2015/15_03/Widget_Corp/public/index.php">
		 <h1 style="color:#8D0D19"> Racoon City Information Center <?php if ($layout_context == "admin"){ echo "Admin";}?></h1>
	</a>
	</div>