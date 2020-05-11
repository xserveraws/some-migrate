<?php
include 'database.php';
if (isset($_POST['reg'])){
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$password = sha1($_POST['password']);
$phone = $_POST['phone'];
$birthday = $_POST['birthday'];
$username = md5($email);
$photoprofile = "images/basic/photoprofile.png";
$photocover = "images/basic/photocover.png";
$activated = "1";



$insert = "INSERT INTO user (fname, lname, gender, email, password, phone, birthday, photoprofile, photocover, username, activated)
VALUES ('$fname', '$lname', '$gender', '$email', '$password', '$phone', '$birthday', '$photoprofile', '$photocover', '$username', '$activated')";
$mysql_q = mysqli_query($conn, $insert);


if($mysql_q == true){
	echo "<script> alert ('Registration Successfully') </script>";
	echo "<script> window.open('index.php', '_self')</script>"; 
	}
} else
	die("Something went wrong or this email it's already in use by other user!")
?>