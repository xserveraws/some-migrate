<?php
include 'database.php';
include 'postcontrol.php';

	$postid=$_GET['id'];
if (isset($_POST['submit'])){
	$status=$_POST['status'];
			$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
			mysqli_select_db($conn,"some") or die ("Couldn't find the database");
			$querychange = mysqli_query($conn,"UPDATE posts SET status='$status' WHERE post_id='$postid'");
			echo "<script> window.open('profile.php?id=".$_SESSION['id']."', '_self')</script>";
			}elseif(isset($_POST['akuro'])){
				echo "<script> window.open('profile.php?id=".$_SESSION['id']."', '_self')</script>";
			}else{
				echo "something went wrong!";
				echo "<script> window.open('profile.php?id=".$_SESSION['id']."', '_self')</script>";
			}
?>