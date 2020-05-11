<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php

 	include('database.php');
 	$user_check=$_GET['id'];
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
  $country=$row['country'];
  $town=$row['town'];
  $birthday=$row['birthday'];
  $bio=$row['bio'];

  if($photoprofile==""){
    $photoprofile = "images/basic/photoprofile.png";
  }
  if($photocover==""){
    $photocover = "images/basic/photocover.png";
  }
?>
<html>
<head>
<link rel="icon" type="image/png" href="images/icon/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Photos: <?php echo $fname;?> <?php echo $lname;?></title>
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

  include('database.php');
  $user_check=$_SESSION['id'];
  $ses_sql=mysqli_query($conn,"select  *  from  user  where  id='$user_check'  ");
  $row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
  $photologprofile=$row['photoprofile'];
        echo $photologprofile;
        ?>
        ">
        </a>
        <a href="#" id="loginregister">Account<img width="12" height="10" src="images/basic/arrow.jpg"></img></a>
				<div class="dropdown-content">
<a href="home.php">Feed</a>
          <b><a href='profile.php?id=
          <?php
            echo $_SESSION["id"];
          ?>
          '>Profile</a></b>
          <a href="messages.php">Message</a>
          <a href="settings.php">Settings</a>
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
    <li><a href='profile.php?id=<?php echo $_GET["id"]; ?>'>Wall</a></li>
    <b><li><a href='photos.php?id=<?php echo $_GET["id"]; ?>'>Photos</a></li></b>
    <li><a href="followers.php?id=<?php echo $_GET["id"]; ?>">Followers</a></li>
    <li><a href="following.php?id=<?php echo $_GET["id"]; ?>">Following</a></li>
          <?php 
          if($email == $_SESSION['email']){
            echo "<li><a href='infos.php?id=".$id." '>Infos</a></li>";
            
            echo "<li><a href='settings.php'>Settings</a></li>";
          }
            else
              echo "<li><a href='infos.php?id=".$id." '>Infos</a></li>";
          ?>
    </ul>
    <aside>
    <?php
    if($_SESSION['id'] != $id){?>
    <form method="post" action="friendreq.php">
    <input type="button" name="addfriend" value="Add Friend">
    <input type="button" name="delfriend" value="Delete Friend">
    </form>
    <?php
    }
    ?>
    Send message to <?php echo $fname; ?><h2><a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $username; ?>')" alt="Chat With <?php echo $fname; ?>">
    <img align="left" src="images/basic/message-icon.png" width="25" height="25">
    </a></h2><br/>
    <strong>Bio</strong><br>
    <?php echo $bio ?>
    </aside>
  </div>
  <article class="content">
    <h1>Photos on profile:</h1>
    <section>
    <?php
    $connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
    mysqli_select_db($conn,"some") or die ("Couldn't find the database");
    $uspo = mysqli_query($conn,"SELECT * FROM posts WHERE onuser='".$_GET['id']."' ORDER BY status_time DESC");
    $posts = "";
    $countpost = mysqli_num_rows($uspo);

    if($countpost == 0){
      $posts = '';
    }else{
      while($rowposts = mysqli_fetch_array($uspo)){
        $post_id = $rowposts['post_id'];
        $user_post_id = $rowposts['user_id_p'];
        $onuser = $rowposts['onuser'];
        $statusimage = $rowposts['status_image'];
        $statustime = $rowposts['status_time'];

    if($statusimage=="NULL"){
      "<b> This users have not photos </b>";
    }else{
      $posts .= '<img style="width: 100%; height: 100%; max-width: 550px; max-height: 240px; object-fit: cover;" src="'.$statusimage.'"></img>
                <br>';
    }


      }
    }
      ?>

      <?php echo $posts ?>

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
