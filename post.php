<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php
include 'database.php';

if (isset($_POST['post'])){
$status = $_POST['status'];
$userpostid = $_SESSION['id'];
$onuser=$_GET["id"];

$insert = "INSERT INTO posts (user_id_p,onuser,status,status_image) VALUES ('$userpostid','$onuser','$status','NULL')";
$mysql_q = mysqli_query($conn, $insert);


if($mysql_q == true){
	echo "<script> alert ('Status Updated Successfully') </script>";
	echo "<script> window.open('profile.php?id=".$onuser."', '_self')</script>"; 
	}
}else{
	echo "<script> alert ('Status Updated Unsuccessfully') </script>";
	echo "<script> window.open('profile.php?id=".$onuser."', '_self')</script>"; 
}
?>