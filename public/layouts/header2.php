<html>
 <head>
 <link rel="icon" href="data:;base64,iVBORw0KGgo=">
 <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
       <title>Photostream</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="http://localhost/ExerciseFiles/Chapter_15/15_03/btb_sandbox/Less/dist/css/bootstrap.min.css" rel="stylesheet">
 </head>
  
<body>
<script src="javascripts/navbar.js" type="text/javascript"></script>
<div class="container">
<div class="row" id="navbar">
    <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" id="nav_bar" role="navigation">
      <div class="container-fluid">
      
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div><!-- navbar-header -->

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">             
                <li><a href="user_home.php">Home</a></li>
                <li><a href="photo_upload.php">Photos</a></li>
                <li><a href="photostream.php">Photostream</a></li>
                <li><a href="manage_folders.php">Folders</a></li>
                <li><a href="edit_user.php">Settings</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>        
            </ul>
            <ul class="nav navbar-nav navbar-right">                
                <?php
                    if (is_session_started() === FALSE) {
                        echo '<li><a href="new_account.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li><li><a href="user_login.php"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>';
                    } else {
                        echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>';
                    }
                ?>
            </ul>
        </div><!-- /.navbar-collapse -->
        
      </div><!-- /.container-fluid -->
    </nav><!-- /.navbar navbar-default navbar-inverse -->
</div> <!-- Row -->
</br></br>
<div class="row">
    <div id="header">
        <h1>Photostream</h1>
    </div>
</div><!-- Row -->