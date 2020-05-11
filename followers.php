<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php

  include 'database.php';
  $mainid=$_GET['id'];
  $followers="";

  $query = mysqli_query($conn,"SELECT * FROM relationship WHERE usertwoid='$mainid' AND actionuserid!='$mainid' AND status='1'");

  $countfollowers = mysqli_num_rows($query);

   while($rowfollowing = mysqli_fetch_array($query)){
   	$useroneid = $rowfollowing['useroneid'];
  	$usertwoid = $rowfollowing['usertwoid'];
 	$status = $rowfollowing['status'];
  	$actionuserid = $rowfollowing['actionuserid'];


 	$query2 = mysqli_query($conn,"SELECT * FROM user WHERE id='$useroneid'");
 	while($rowuserinfos = mysqli_fetch_array($query2)){
   	$id = $rowuserinfos['id'];
  	$fname = $rowuserinfos['fname'];
 	$lname = $rowuserinfos['lname'];
  	$photoprofile = $rowuserinfos['photoprofile'];
  	}
   	$followers .= ' <a href="profile.php?id='.$useroneid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$photoprofile.'"></img>'.$fname.' '.$lname.' </a><br> ';
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
  <script type="text/javascript"></script>
  <script src="assets/jscript/search.js"></script>
<title>Total users followers: <?php echo $countfollowers; ?></title>
</head>
<body>
<font color="white">
<section>
<center>
Your followers: <?php echo $countfollowers; ?>
<hr>
<?php echo $followers; ?>
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