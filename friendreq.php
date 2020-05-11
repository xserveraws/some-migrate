<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php

	include 'database.php';

	$user1=$_SESSION['id'];
	$user2=$_GET['id'];

	$sendreq = "INSERT INTO `relationship` (`useroneid`, `usertwoid`, `status`, `actionuserid`) VALUES ($user1, $user2, 0, $user1)";

	$fr = mysqli_query($conn, $sendreq);


	if((isset($_POST['addfriend'])) AND ($fr == true)){
		echo "<script> alert ('Follow request sent successfully!') </script>";
		echo "<script> window.open('profile.php?id=".$user1."', '_self')</script>"; 
	}elseif (isset($_POST['block'])){
		$blockreq = "UPDATE relationship SET status='3' WHERE useroneid='$user1' and usertwoid='$user2'";
		echo "<script> alert ('You blocked this user!') </script>";
		$bre = mysqli_query($conn, $blockreq);
		echo "<script> window.open('profile.php?id=".$user1."', '_self')</script>"; 
	}elseif (isset($_POST['unfollow'])){
		$unfollow = "UPDATE relationship SET status='2' WHERE useroneid='$user1' and usertwoid='$user2'";
		echo "<script> alert ('You unfollow this user!') </script>";
		$unf = mysqli_query($conn, $unfollow);
		echo "<script> window.open('profile.php?id=".$user1."', '_self')</script>"; 
	}else{
		$check = "UPDATE relationship SET status='0' WHERE useroneid='$user1' and usertwoid='$user2'";
		echo "<script> alert ('Already sent follow request!') </script>";
		$che = mysqli_query($conn, $check);
		echo "<script> window.open('profile.php?id=".$user1."', '_self')</script>"; 
	}

	
?>