<?php
require 'database.php';
?>
<?php
session_start();

$email = $_POST['email'];
$password = sha1($_POST['password']);

if($email&&$password){

	$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
	
	mysqli_select_db($connect, "some") or die ("Couldn't find the database");
	
	
	
	//$numrows = mysqli_num_rows(mysqli_result $query);
	if ($query = mysqli_query($connect, "SELECT * FROM user WHERE email='$email'")) {

		/* determine number of rows result set */
		$row_cnt = mysqli_num_rows($query);
	
		printf("Result set has %d rows.\n", $row_cnt);
	
		/* close result set */
		mysqli_free_result($numrows);
	}
	
	if ($numrows!==0){
		while($row = mysqli_fetch_assoc($query)){
			$dbemail = $row['email'];
			$dbpassword = $row['password'];
			$dbid = $row['id'];
			$dbstatus = $row['status'];
			$dbfname = $row['fname'];
			$dbphone = $row['phone'];
			$dbun = $row['username'];
			$dbactivated = $row['activated'];
		}
		if($email == $dbemail&&$password==$dbpassword){
			//echo "<script> alert ('You are logged in! ') </script>";
			echo "<script> window.open('home.php', '_self')</script>";
			$status = mysqli_query($connect,"UPDATE user SET status='online' WHERE id='$dbid'");
			if($dbactivated == 0){
			$activate = mysqli_query($connect,"UPDATE user SET activated='1' WHERE id='$dbid'");
			}
			@$_SESSION['email'] = $email;
			@$_SESSION['id'] = $dbid;
 			@$_SESSION['fname'] = $dbfname;
 			@$_SESSION['phone'] = $dbphone;
 			@$_SESSION['username'] = $dbun;
 			@$_SESSION['activated'] = $dbactivated;
			setcookie('email',md5($email,$password),time()+86400);
		}
		else
			echo "<script> alert ('Your password is incorrect!') </script>";
			echo "<script> window.open('index.php', '_self')</script>"; 
	}
	else
	echo '<script type="text/javascript">alert("That user does not exists!");</script>';
	echo "<script> window.open('index.php', '_self')</script>";
}
else
	echo '<script type="text/javascript">alert("Please enter a email and password!");</script>';
	echo "<script> window.open('index.php', '_self')</script>";
?>