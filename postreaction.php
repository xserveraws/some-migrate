<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php
include 'database.php';
//include 'postcontrol.php';

	$postid=$_GET['id'];
if (isset($_POST['postcom'])){
	$comment=$_POST['commentbody'];
	$commenterid=$_SESSION['id'];

			$insert = "INSERT INTO comments (comment,commenterid,postid) VALUES ('$comment','$commenterid','$postid')";
			$mysql_q = mysqli_query($conn, $insert);


			$selectposter = "SELECT * FROM posts WHERE post_id='$postid'";
			$mysql_qu = mysqli_query($conn, $selectposter);
			$rowposter=mysqli_fetch_array($mysql_qu);
            $posterid=$rowposter['onuser'];


			if($mysql_q == true AND $mysql_qu == true){
				echo "<script> alert ('Comment Successfully!') </script>";
				echo "<script> window.open('profile.php?id=".$posterid."', '_self')</script>"; 
				}
			} else {
				echo "<script> alert ('Failed to comment!') </script>";
				echo "<script> window.open('profile.php?id=".$posterid."', '_self')</script>"; 
			}

?>