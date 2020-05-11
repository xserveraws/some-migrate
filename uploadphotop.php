<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php
  include('database.php');
  $user_check=$_SESSION['email'];
  $ses_sql=mysqli_query($conn,"select  *  from  user  where  email='$user_check'  ");
  $row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
  $fname=$row['fname'];
  $lname=$row['lname'];
?>
<?php
  include('database.php');
  $user_check=$_SESSION['id'];
  $ses_sql=mysqli_query($conn,"select  *  from  user  where  id='$user_check'  ");
  $row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
  $id=$row['id'];
  $fname=$row['fname'];
  $lname=$row['lname'];
  $gender=$row['gender'];
  $email=$row['email'];
  $phone=$row['phone'];
  $photoprofile=$row['photoprofile'];
  $photocover=$row['photocover'];
  $bio=$row['bio'];

  if($photoprofile==""){
    $photoprofile = "images/basic/photoprofile.png";
  }
  if($photocover==""){
    $photocover = "images/basic/photocover.png";
  }
?>
<?php
$timenow=date("Ymdhis");
mkdir("images/users/".$id."/");
mkdir("images/users/".$id."/photoprofile");
mkdir("images/users/".$id."/photoprofile/".$timenow."/");
$target_dir = "images/users/".$id."/photoprofile/".$timenow."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if(isset($_POST["submit"])) {
        
          $connect = mysqli_connect("localhost","root","");
          mysqli_select_db($conn,"some");
          $queryget = mysqli_query($conn,"SELECT photoprofile FROM user WHERE id='$id'") or die("Something went wrong!");
          $row = mysqli_fetch_assoc($queryget);
          $querychange = mysqli_query($conn,"UPDATE user SET photoprofile='$target_file' WHERE id='$id'");
          echo '<script type="text/javascript">alert("Photo changed successfully!");</script>';
        
    }


if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo '<script type="text/javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>';
    $uploadOk = 0;
    $target_file = "images/basic/photoprofile.png";
    $querychange = mysqli_query($conn,"UPDATE user SET photoprofile='$target_file' WHERE id='$id'");
}

if ($uploadOk == 0) {
    echo '<script type="text/javascript">alert("Sorry, your file was not uploaded.");</script>';
    $target_file = "images/basic/photoprofile.png";
    $querychange = mysqli_query($conn,"UPDATE user SET photoprofile='$target_file' WHERE id='$id'");
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "<script> window.open('profile.php?id=".$id."', '_self')</script>"; 
    } else {
        echo '<script type="text/javascript">alert("Sorry, there was an error uploading your file.");</script>';
        $target_file = "images/basic/photoprofile.png";
        $querychange = mysqli_query($conn,"UPDATE user SET photoprofile='$target_file' WHERE id='$id'");
    }
}
?>