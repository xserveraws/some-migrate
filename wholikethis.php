<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php

  include 'database.php';
  $post_id=$_GET['id'];
  $likers="";

  $query = mysqli_query($conn,"SELECT * FROM likes WHERE postid='$post_id' AND likestatus='1'");

  $countlikes = mysqli_num_rows($query);

   while($rowlikers = mysqli_fetch_array($query)){
   	$likeuseroneid = $rowlikers['likeuseroneid'];
  	$likeusertwoid = $rowlikers['likeuseroneid'];

 	$query2 = mysqli_query($conn,"SELECT * FROM user WHERE id='$likeuseroneid'");
 	while($rowuserinfos = mysqli_fetch_array($query2)){
   	$id = $rowuserinfos['id'];
  	$fname = $rowuserinfos['fname'];
 	$lname = $rowuserinfos['lname'];
  	$photoprofile = $rowuserinfos['photoprofile'];
  	}
   	$likers .= ' <a href="profile.php?id='.$likeuseroneid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$photoprofile.'"></img>'.$fname.' '.$lname.' </a><br> ';
   }
?>

<html>
<head>
<link rel="icon" type="image/png" href="images/icon/favicon.ico">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link type="text/css" rel="stylesheet" media="all" href="assets/css/chat.css" />
  <link type="text/css" rel="stylesheet" media="all" href="assets/css/post.css" />
  <!--<link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">-->
  <script type="text/javascript"></script>
  <!--<script src="assets/jscript/jquery.min.js"></script>-->
  <script src="assets/jscript/search.js"></script>
<title>Who like this post?</title>
</head>
<body>
<font color="white">
<section>
<center>
Total Likes: <?php echo $countlikes; ?>
<hr>
<?php echo $likers; ?>
</center></section></font>
<div class="footer">
<font color="white" size="2">
<form method="get" action="search.php" class="searchbox">
<input type="text" class="search" placeholder="Search for friends..." name="search">
</form>
</font>
</div>
</body>
</html>