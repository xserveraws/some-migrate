<?php
include 'database.php';    
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="images/icon/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="assets/icons/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/styleprofile.css">
  <link type="text/css" rel="stylesheet" media="all" href="assets/css/chat.css" />
<style type="text/css">

</style>
	<title>REPORT BUGS</title>
</head>
<body>
<form method="post" action="reportbugs.php" name="reportbugs">
<textarea style="resize:none" cols="50" rows="10" name="reports" placeholder="Report your bugs here..."></textarea><br>
<input type="submit" name="bugs" value="Submit">
<?php

      if(isset($_POST['bugs'])){
      $bugs = $_POST['reports'];
      $insert = "INSERT INTO bugs (bugs) VALUES ('$bugs')";
		$mysql_q = mysqli_query($conn, $insert);
      echo '<script type="text/javascript">alert("Bugs reported successfully!");</script>';
      }  
?>
</form>
</body>
</html>