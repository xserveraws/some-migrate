<?php
session_start();
if(isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: home.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="images/icon/favicon.ico">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<title>Welcome to SoMe</title>
	<link rel="icon" href="assets/icons/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script type="text/javascript"></script>
	<SCRIPT TYPE="text/javascript"> function popup(mylink, windowname) { if (! window.focus)return true; var href; if (typeof(mylink) == 'string') href=mylink; else href=mylink.href; window.open(href, windowname, 'width=400,height=25,scrollbars=no'); return false; } </SCRIPT>
	<script>
	function validateemail() {
    var x = document.forms["registerform"]["email"].value;
    var papaki = x.indexOf("@");
    var telia = x.lastIndexOf(".");
	    if (papaki<1 || telia<papaki+2 || telia+2>=x.length) {
	        alert("Not a valid e-mail address!");
	        return false;
	    }
	}
	</script>
</head>
<body onLoad="popup('coockieschange.html', 'cookiesmsg')">
	<nav>
		<section class="nav-container">
			<aside class="logo"><a href="index.php"><img src="images/logos/logo.jpg"></a></aside>
			<aside class="menu">
			<div class="dropdown">
				<a href="#" id="loginregister">Account<img width="12" height="10" src="images/basic/arrow.jpg"></img></a>
				<div class="dropdown-content">
					<a href="mailto::supportsome@gmail.com">Lost Your Password?</a>
					<a href="reportbugs.php">Report Bugs</a>
				</div>
			</div>
			</aside>
		</section>
	</nav>
<br>
<center><h1><font color="white">Welcome to SoMe</font></h1></center>
<br>
<div class="left-side">
	<form name="registerform" method="post" onsubmit="return validateemail();" action="register.php">
		<h1>Register</h1>
		<label>First Name: </label>
		<div>
			<input type="text" name="fname" placeholder="First Name" required/>
		</div>
			<label>Last Name: </label>
		<div>
			<input type="text" name="lname" placeholder="Last Name" required/>
		</div>
			<label>Gender</label>
		<div>
		<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male");?> value="male">Male
		<input type="radio" name="gender" <?php if (isset($gender) && $gender=="female");?> value="female">Female
		</div>
			<label>Email: </label>
		<div>
			<input type="text" name="email" placeholder="Email" required/>
		</div>
			<label>Password: </label>
		<div>
			<input type="password" name="password" placeholder="Password" required/>
		</div>
			<label>Phone: </label>
		<div>
			<input type="text" pattern="^\d{10}$" name="phone" placeholder="Phone" required/>
		</div>
			<label>Birthday: </label>
		<div>
			<input type="text" pattern="^\d{4}[\-]\d{2}[\-]\d{2}$" name="birthday" placeholder="yyyy-mm-dd" required>
		</div>
		<div>
			<input type="submit" name="reg" value="Register"/>
		</div>
	</form>
</div>
	<div class="right-side">
		<form name="loginform" method="POST" action="login.php">
			<h1>Login</h1>
				<label>Email: </label>
			<div>
				<input type="text" placeholder="Email" name="email" required/>
			</div>
				<label>Password: </label>
			<div>
				<input type="password" placeholder="Password" name="password" required/>
			</div>
			<div>
				<input type="submit" value="Log In"/>
			</div>
		</form>
	</div>

<div class="footer">
<font color="white" size="2">SoMe Company, <?php echo date("Y"); ?> ™. All Rights Reserved ®</font>
</div>
</body>
</html>