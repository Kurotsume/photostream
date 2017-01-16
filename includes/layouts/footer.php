<div id="footer">Copyright <?php echo date("Y");?>, Widget Corp</div>
	</body>
</html>
<?php
	 //5. Close Database connection
	 if (isset($connection)){
	 	mysqli_close($connection);
	 }
?>