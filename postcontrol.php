<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php
include 'database.php';

if (isset($_POST['edit'])){
	$postid=$_GET['id'];
	$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
	mysqli_select_db($conn,"some") or die ("Couldn't find the database");
	$selectpost = mysqli_query($conn,"SELECT * FROM posts WHERE post_id='$postid'");
		if($selectpost){
			while($rowposts = mysqli_fetch_array($selectpost)){
			    $post_id = $rowposts['post_id'];
			    $user_post_id = $rowposts['user_id_p'];
			    $onuser = $rowposts['onuser'];
			    $status = $rowposts['status'];
			    $statusimage = $rowposts['status_image'];
			    $statustime = $rowposts['status_time'];

				echo "<form method='post' action='postedit.php?id=$postid'>
				<textarea placeholder='$status' name='status'>$status</textarea>
				<input type='submit' name='submit' value='save'>
				<input type='submit' name='akuro' value='cancel'>
				</form>";

			}			
		}
}

if (isset($_POST['delete'])){
	$postid=$_GET['id'];
	$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
	mysqli_select_db($conn,"some") or die ("Couldn't find the database");
	$selectpost = mysqli_query($conn,"SELECT * FROM posts WHERE post_id='$postid'");
		if($selectpost){
			while($rowposts = mysqli_fetch_array($selectpost)){
			    $post_id = $rowposts['post_id'];
			    $user_post_id = $rowposts['user_id_p'];
			    $onuser = $rowposts['onuser'];
			    $status = $rowposts['status'];
			    $statusimage = $rowposts['status_image'];
			    $statustime = $rowposts['status_time'];

				echo "<form method='post' action='deletepost.php?id=$postid'>
				$status
				<input type='submit' name='delete' value='delete'>
				<input type='submit' name='akuro' value='cancel'>
				</form>";

			}			
		}
}
?>