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
    $photoprofile = "some/images/basic/photoprofile.png";
  }
  if($photocover==""){
    $photocover = "some/images/basic/photocover.png";
  }
?>
<html>
<head>
<link rel="icon" type="image/png" href="images/icon/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Settings Profile: <?php echo $fname;?> <?php echo $lname;?></title>
<link rel="icon" href="assets/icons/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/styleprofile.css">
  <link type="text/css" rel="stylesheet" media="all" href="assets/css/chat.css" />
<style type="text/css">

</style>
</head>
<body>

<script type="text/javascript" src="assets/jscript/jquery.js"></script>
<script type="text/javascript" src="assets/jscript/chat.js"></script>

<nav>
    <section class="nav-container">
      <aside class="logo"><a href="index.php"><img src="images/logos/logo.jpg"></a></aside>
      <aside class="menu">
      <div class="dropdown">
      <a href='profile.php?id=
          <?php
            echo $_SESSION["id"];
          ?>
          '>
        <img style="width: 100%; height: 100%;max-width: 20px;max-height: 20px; object-fit: cover;" src="
        <?php
        echo $photoprofile;
        ?>
        ">
        </a>
        <a href="#" id="loginregister">Account<img width="12" height="10" src="images/basic/arrow.jpg"></img></a>
        <div class="dropdown-content">
          <a href="home.php">Feed</a>
          <a href='profile.php?id=
          <?php
            echo $_SESSION["id"];
          ?>
          '>Profile</a>
          <a href="messages.php">Message</a>
          <b><a href="settings.php">Settings</a></b>
          <a href="requestlist.php">Follow Requests</a>
          <a href="reportbugs.php">Report Bugs</a>
          <a href="logout.php">Log Out</a>
        </div>
      </div>
      </aside>
    </section>
  </nav>
<div class="container">
  <header>
  <a href="changephoto.php">
  <?php
  echo "<img class='profile' style='width: 100%; height: 100%;max-width: 250px;max-height: 250px; object-fit: cover;' src='" . $photoprofile . "'/> ";
  ?>
  </a>
  <a href="changecover.php">
  <?php
  echo "<img class='cover' style='width: 100%; height: 100%;max-width: 700px;max-height: 250px; object-fit: cover;' src='" . $photocover . "'/> ";
  ?>
  </a>
  </header>
  <div class="sidebar1">
    <ul class="navi">
    <li><a href='profile.php?id=<?php echo $_SESSION["id"]; ?>'>Wall</a></li>
    <li><a href='photos.php?id=<?php echo $_SESSION["id"]; ?>'>Photos</a></li>
    <li><a href="followers.php?id=<?php echo $_SESSION["id"]; ?>">Followers</a></li>
    <li><a href="following.php?id=<?php echo $_SESSION["id"]; ?>">Following</a></li>
          <?php 
          if($email == $_SESSION['email']){
            echo "<li><a href='infos.php?id=".$id." '>Infos</a></li>";
            
            echo "<b><li><a href='settings.php'>Settings</a></li></b>";
          }
            else
              echo "<li><a href='infos.php?id=".$id." '>Infos</a></li>";
          ?>
    </ul>
    
    <aside>
    <h2>Bio</h2>
    <?php echo $bio ?>
    </aside>
  </div>
  <article class="content">
    <h1>Settings:</h1>
    <section>
    <h1>Change Photo Cover</h1>
    <table>
    <tr>
    <td align="center" bgcolor="#9999ff"><a href="changephoto.php">Change Photo</a></td>
    <td align="center" bgcolor="#eb99ff"><a href="changecover.php">Change Cover Photo</a></td></tr>
    <tr>
    <td align="center" bgcolor="#ff99e6"><a href="changeemail.php">Change E-mail</a></td>
    <td align="center" bgcolor="#ff9999"><a href="changepassword.php">Change Password</a></td></tr>
    <tr>
    <td align="center" bgcolor="#ffcc99"><a href="changename.php">Change Name</a></td>
    <td align="center" bgcolor="#99ff99"><a href="changephone.php">Change Phone</a></td></tr>
    <tr>
    <td align="center" bgcolor="#ffff99"><a href="changeinfos.php">Change Infos</a></td>
    <td align="center" bgcolor="#99ffff"><a href="changebio.php">Change Bio</a></td></tr>
    <tr>
    <td align="center" bgcolor="#cccccc"><a href="disable.php">Disable Account</a></td>
    <td align="center"  bgcolor="#f2f2f2"><a href="changeusername.php">Change Username</a></td>
    </tr>
    </table><br>


<form action="uploadphotocover.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

    </section>
  </article>
  <footer>
  </footer>
  </div>
<div class="footer">
<font color="white" size="2">
<form method="get" action="search.php" class="searchbox">
<input type="text" class="search" placeholder="Search for friends..." name="search">
</form>
</font>
</div>
</body>
</html>