<?php
session_start();
/*
$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
	mysqli_select_db($conn,"some") or die ("Couldn't find the database");
*/
	include('database.php');

$id = $_GET['id'];
$useroneid="";
$usertwoid="";
$status="";
$actionuserid="";

$myid=$_SESSION['id'];

$query = mysqli_query($conn,"SELECT * FROM relationship WHERE usertwoid='$myid' AND status='0'");
while($row1 = mysqli_fetch_array($query)){
		$useroneid = $row1['useroneid'];
		$usertwoid = $row1['usertwoid'];
		$status = $row1['status'];
		$actionuserid = $row1['actionuserid'];
	}

$query2 = mysqli_query($conn,"SELECT * FROM user WHERE id='$useroneid'");
while($row = mysqli_fetch_array($query2)){
		$fname = $row['fname'];
		$lname = $row['lname'];
	}

if($_POST['accept']){
$setfr = mysqli_query($conn,"UPDATE `relationship` SET `status` = 1 WHERE `useroneid` = '$useroneid' AND `usertwoid` = '$usertwoid'");
echo '<script type="text/javascript">alert("Now this user following you!");</script>';
	echo "<script> window.open('requestlist.php', '_self')</script>";
	//echo "<script> window.open('requestlist.php?id=".$id."', '_self')</script>";
}elseif($_POST['ignore']){
$setfr =  mysqli_query($conn,"UPDATE `relationship` SET `status` = 2 WHERE `useroneid` = '$useroneid' AND `usertwoid` = '$usertwoid'");
echo '<script type="text/javascript">alert("You ignore this follow request!");</script>';
	echo "<script> window.open('requestlist.php?id=".$id."', '_self')</script>";
}
?>