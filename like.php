<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php
include 'database.php';
if (isset($_POST['like'])){
	$likerid=$_SESSION['id'];
	$postid=$_GET['id'];



			$selectposter = "SELECT * FROM posts WHERE post_id='$postid'";
			$mysql_qu = mysqli_query($conn, $selectposter);
			$rowposter=mysqli_fetch_array($mysql_qu);
            $posterid=$rowposter['onuser'];
            	$insertlike = "INSERT INTO likes (likeuseroneid,likeusertwoid,postid,likestatus) VALUES ('$likerid','$posterid','$postid','1')";
				$mysql_quc = mysqli_query($conn, $insertlike);

			if($mysql_qu == true AND $mysql_quc == true){
				echo "<script> alert ('Like Successfully!') </script>";
				echo "<script> window.open('profile.php?id=".$posterid."', '_self')</script>"; 
				}else{
				$unlike = "UPDATE likes SET likestatus='1' where likeuseroneid='$likerid' and postid='$postid'";
				$mysql_quc = mysqli_query($conn, $unlike);
				echo "<script> alert ('You like this post!') </script>";
				echo "<script> window.open('profile.php?id=".$posterid."', '_self')</script>"; 
			}
			} 
?>