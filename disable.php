<?php
require 'database.php';
require 'login.php';
?>
<?php


	$email=$_SESSION['email'];

	$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
	
	mysqli_select_db($conn,"some") or die ("Couldn't find the database");
	
	$query = mysqli_query($conn,"SELECT * FROM user WHERE email='$email'");
	
	$numrows = mysqli_num_rows($query);

	if ($numrows!==0){
		while($row = mysqli_fetch_assoc($query)){
		$dbemail = $row['email'];
		$dbid = $row['id'];
		$dbstatus = $row['status'];
		}
			if($email == $dbemail && $dbstatus == "online"){
				$status = mysqli_query($conn,"UPDATE user SET status='offline' WHERE id='$dbid'");
				$activate = mysqli_query($conn,"UPDATE user SET activated='0' WHERE id='$dbid'");
				echo "<script> alert ('This account is now deactivated since you log in again!') </script>";
				echo "<script> window.open('index.php', '_self')</script>"; 
			}
		}else{
			echo "<script> alert ('Something went wrong!') </script>";
			echo "<script> window.open('index.php', '_self')</script>"; 
	}

if (isset($_SERVER['HTTP_COOKIE']))
{
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie)
    {
        $mainCookies = explode('=', $cookie);
        $name = trim($mainCookies[0]);
        setcookie($name, '', time()-100000);
        setcookie($name, '', time()-100000, '/');
    }
}


session_destroy();
header('Location: index.php');
?>