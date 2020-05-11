<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
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
  $username=$row['username'];
  $activated=$row['activated'];

 	$messacheck=$username;
  	$messages=mysqli_query($conn,"select  *  from  chat  where  (chat.from='".$messacheck."') or (chat.to='".$messacheck."') order by sent desc");



  //-----------------------------------------
  $output = "";
$count = mysqli_num_rows($messages);

if($count == 0){
  $output = 'There was no messages results!';
}else{
  while($rowme = mysqli_fetch_array($messages)){
    $idm=$rowme['id'];
    $fromm=$rowme['from'];
    $tom=$rowme['to'];
    $messagem=$rowme['message'];
    $sentm=$rowme['sent'];

    //$output .= '<tr><td>'.$messagem.'</td>';
   // $output .= '<td>'.$fromm.'</td>';
    $output .= '<option value="'.$messagem.'">'.$tom.'</option>';
  }
}
  //-----------------------------------------







  if($activated == 0){
    echo '<script type="text/javascript">alert("This account is deactivated!");</script>';
    die;
  }

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
<title>Profile: <?php echo $fname;?> <?php echo $lname;?></title>
<link rel="icon" href="assets/icons/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/styleprofile.css">
  <link type="text/css" rel="stylesheet" media="all" href="assets/css/chat.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/post.css">
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
          <b><a href="messages.php">Message</a></b>
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
  </header>
  <div class="sidebar1">
    <ul class="navi">
    </ul>
    <aside>
    <select>
    <?php print("$output"); ?>
    </select> 
    </aside>
  </div>
  <article class="content">
    <section>
    <!--<table border="2px">
    <?php print("$output"); ?>
    </table>-->
    <!--
    <table width="500" height="200" border="2px">
    <tr><th>Message</th><th>From</th><th>Time</th></tr>
    <?php
    echo "<tr><td height='200'>".$messagem."</td>"; 

    echo "<td height='200'>".$fromm."</td>";

    echo "<td height='200'>".$sentm."</td></tr>";
    ?>
    </table>
    <from method="post" action="messages.php">
    <input readonly type="text" name="from" value="<?php echo $fromm; ?>"><br/>
    <input readonly type="text" name="from" value="<?php echo $tom; ?>"><br/>
    <textarea readonly name="mhnuma"><?php echo $messagem; ?></textarea>
    </from>-->
    <!--
    <tr><td height="200" colspan="3"><?php echo $list['message']; ?></td></tr>-->
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