<?php
require 'database.php';
?>
<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php
$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
	mysqli_select_db($conn,"some") or die ("Couldn't find the database");
$search = $_GET['search'];
$search = preg_replace("#[^0-9a-z]#i", "", $search);

$query = mysqli_query($conn,"SELECT * FROM user WHERE fname LIKE '%$search%' OR lname LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%'");
$output = "";
$count = mysqli_num_rows($query);

if($count == 0){
	$output = 'There was no search results!';
}else{
	while($row = mysqli_fetch_array($query)){
		$fname = $row['fname'];
		$lname = $row['lname'];
		$photoprofile = $row['photoprofile'];
		$id = $row['id'];

		$output .= '<tr><td><a href="profile.php?id='.$id.'"><img style="width: 100%; height: 100%;max-width: 50px;max-height: 50px; object-fit: cover;" src="'.$photoprofile.'">'.$fname.' '.$lname.'</img></a></td></tr>';
	}
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
<title>Search: <?php echo $search; ?></title>
</head>
<body>
<font color="white">
<section>
<center>
Search for <?php echo $search; ?>:
<hr>
<table border="2px">
<?php print("$output"); ?>
</table>
</center>
<div class="footer">
<font color="white" size="2">
<form method="get" action="search.php" class="searchbox">
<input type="text" class="search" placeholder="Search for friends..." name="search">
</form>
</font>
</div>
</body>
</html>