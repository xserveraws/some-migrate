<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php
include 'database.php';
if (isset($_POST['uploadphoto'])){
$userpostid = $_SESSION['id'];
$onuser=$_GET["id"];
$fileToUpload = $_FILES['fileToUpload']['name'];

mkdir("images/users/".$onuser."/");
mkdir("images/users/".$onuser."/timelinephotos");
$target_dir = "images/users/".$onuser."/timelinephotos/";
$target_file = $target_dir . basename($fileToUpload);
echo $target_file;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$connect = mysqli_connect("localhost","root","");
		         mysqli_select_db($conn,"some");
$insert = "INSERT INTO posts (user_id_p,onuser,status,status_image) VALUES ('$userpostid','$onuser','','$target_file')";
$querypostphoto = mysqli_query($conn, $insert);

if($querypostphoto == true){
	echo "<script> alert ('Photo Status Updated Successfully') </script>";
	echo "<script> window.open('profile.php?id=".$onuser."', '_self')</script>"; 
	}
 


}else{
	echo "<script> alert ('Photo Status Updated Unsuccessfully') </script>";
	echo "<script> window.open('profile.php?id=".$onuser."', '_self')</script>"; 
}


if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo '<script type="text/javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>';
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo '<script type="text/javascript">alert("Sorry, your file was not uploaded.");</script>';
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo '<script type="text/javascript">alert("Photo posted successfully!");</script>';
    echo "<script> window.open('profile.php?id=".$onuser."', '_self')</script>";
      
    } else {
        echo '<script type="text/javascript">alert("Sorry, there was an error uploading your file.");</script>';
    }
}


?>