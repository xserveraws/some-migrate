<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php
 	include('database.php');

$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
	mysqli_select_db($conn,"some") or die ("Couldn't find the database");


$id = $_SESSION['id'];
$useroneid="";
$usertwoid="";
$status="";
$actionuserid="";

$query = mysqli_query($conn,"SELECT * FROM relationship WHERE usertwoid='$id' AND status='0'");
while($row1 = mysqli_fetch_array($query)){
		$useroneid = $row1['useroneid'];
		$usertwoid = $row1['usertwoid'];
		$status = $row1['status'];
		$actionuserid = $row1['actionuserid'];
	}

$output = "";
$count = mysqli_num_rows($query);
@$_SESSION['count'] = $count;

if($count == 0){
	echo "<script> alert ('Not found more follower requests!') </script>";
	echo "<script> window.open('profile.php?id=".$id."', '_self')</script>";
}else{
	$query2 = mysqli_query($conn,"SELECT * FROM user WHERE id='$useroneid'");
	while($row = mysqli_fetch_array($query2)){
		$fname = $row['fname'];
		$lname = $row['lname'];
		$photoprofile = $row['photoprofile'];
		$id = $row['id'];

		$output .= '<tr><td><a href="profile.php?id='.$id.'"><img style="width: 100%; height: 100%;max-width: 50px;max-height: 50px; object-fit: cover;" src="'.$photoprofile.'">'.$fname.' '.$lname.'</img></a></td></tr>
			<tr><td><form method="post" action="answer.php?id='.$_SESSION['id'].'"><input type="submit" value="Accept" name="accept"><input type="submit" name="ignore" value="Ignore"></td></form></td></tr>';
	}
}
?>

<html>
<head>
<link rel="icon" type="image/png" href="images/icon/favicon.ico">
<title>You have <?php echo $count; ?> follow requests!</title>
</head>
<body>
<table border="2px">
<?php print("$output"); ?>
</table>
</body>
</html>