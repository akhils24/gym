<?php
include ("head.php");
if(isset($_POST["submit"])) {
	$email=$_POST['username'];
	$pass=$_POST['passd'];
	$emailres = $conn->prepare("SELECT * FROM `login` WHERE username = ?");
    $emailres->bind_param("s", $email);  // 's' means the parameter is a string
    $emailres->execute();
    $result = $emailres->get_result();
	if(mysqli_num_rows($result) > 0) {
		$emailrow=mysqli_fetch_assoc($result);
		$email = $emailrow['username'];
		$tblrow=mysqli_query($conn,"SELECT * FROM `login` WHERE username = '$email'");
		$tblres=mysqli_fetch_assoc($tblrow);
		if($tblres['login_status']=='1') {
			$passrow=$tblres['password'];
			if($pass != $passrow) {
				echo "<script>alert('Your Password is Inccorrect..');</script>";
			} else{
				$usrtyp=$tblres['user_type'];
				if($usrtyp == 'CU') {
					$qry=mysqli_query($conn,"SELECT * FROM customer WHERE username ='$email'");
					$rs=mysqli_fetch_assoc($qry);
					$_SESSION['userid']= $rs['customer_id'];
					$_SESSION['usertype'] = 'CU';
					echo "<script>alert('You have succesfully logged in .');window.location.href='index.php';</script>";
				} elseif($usrtyp == 'AD') {
					$_SESSION['userid'] = 'ADMIN';
					$_SESSION['usertype'] = 'AD';
					echo "<script>alert('You have succesfully logged in .');window.location.href='admin/index.php';</script>";
				} elseif($usrtyp == 'ST') {
					$qry=mysqli_query($conn,"SELECT * FROM staff WHERE username ='$email'");
					$rs=mysqli_fetch_assoc($qry);
					$_SESSION['userid']= $rs['staff_id'];
					$_SESSION['usertype'] = 'ST';
					echo "<script>alert('You have succesfully logged in .');window.location.href='admin/index.php';</script>";
				}
			}
		} else{
			echo "<script>alert('You are not authorised to enter into the platform.');</script>";
		}
	} else{
		echo "<script>alert('We Cannot find an account with that email address.');</script>";
	}
}
?>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>login</title>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/all.css'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css'>
<!-- <link rel="stylesheet" href="./style.css"> -->

</head>
<body>
<nav>
	<img src="assets/logo/logo.png" class="logo">
	<ul>
			<li><a href="index.php">HOME</a></li>
			<li><a href="login.php">LOGIN</a></li>
			<li><a href="">ABOUT US</a></li>
			<li><a href="">CONTACT US</a></li>
	</ul>
</nav> 
<br>
<!-- partial:index.partial.html -->
<div class="container">  
	<div class="screen">
		<div class="screen__content">
			<form class="login" method="POST" action="login.php" >
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" class="login__input" placeholder="Email" name="username" required>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" class="login__input" placeholder="Password" name="passd" required>
				</div>
				<button class="button login__submit" type="submit" name="submit">
					<span class="button__text">Log In Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
			<div class="social-login">
				<!-- <h3 ></h3> -->
				<div class="social-icons">
					<a style="color:white;font-weight: bold;" href="register.php" class="social-login__icon ">Sign-In</a>
					<!-- <a href="#" class="social-login__icon fab fa-facebook"></a>
					<a href="#" class="social-login__icon fab fa-twitter"></a> -->
				</div>
			</div>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
<!-- partial -->
  <style>
	@import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;	
	font-family: Raleway, sans-serif;
}

body {
	background: linear-gradient(90deg, #C7C5F4, #776BCC);		
}

.container {
	margin-top:40px;
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 100vh;
}

.screen {		
	background: linear-gradient(90deg, #5D54A4, #7C78B8);		
	position: relative;	
	height: 600px;
	width: 360px;	
	box-shadow: 0px 0px 24px #5C5696;
}

.screen__content {
	z-index: 1;
	position: relative;	
	height: 100%;
}

.screen__background {		
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	z-index: 0;
	-webkit-clip-path: inset(0 0 0 0);
	clip-path: inset(0 0 0 0);	
}

.screen__background__shape {
	transform: rotate(45deg);
	position: absolute;
}

.screen__background__shape1 {
	height: 520px;
	width: 520px;
	background: #FFF;	
	top: -50px;
	right: 120px;	
	border-radius: 0 72px 0 0;
}

.screen__background__shape2 {
	height: 220px;
	width: 220px;
	background: #6C63AC;	
	top: -172px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape3 {
	height: 540px;
	width: 190px;
	background: linear-gradient(270deg, #5D54A4, #6A679E);
	top: -24px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape4 {
	height: 400px;
	width: 200px;
	background: #7E7BB9;	
	top: 420px;
	right: 50px;	
	border-radius: 60px;
}

.login {
	width: 320px;
	padding: 30px;
	padding-top: 156px;
}

.login__field {
	padding: 20px 0px;	
	position: relative;	
}

.login__icon {
	position: absolute;
	top: 30px;
	color: #7875B5;
}

.login__input {
	border: none;
	border-bottom: 2px solid #D1D1D4;
	background: none;
	padding: 10px;
	padding-left: 24px;
	font-weight: 700;
	width: 75%;
	transition: .2s;
}

.login__input:active,
.login__input:focus,
.login__input:hover {
	outline: none;
	border-bottom-color: #6A679E;
}

.login__submit {
	background: #fff;
	font-size: 14px;
	margin-top: 30px;
	padding: 16px 20px;
	border-radius: 26px;
	border: 1px solid #D4D3E8;
	text-transform: uppercase;
	font-weight: 700;
	display: flex;
	align-items: center;
	width: 100%;
	color: #4C489D;
	box-shadow: 0px 2px 2px #5C5696;
	cursor: pointer;
	transition: .2s;
}

.login__submit:active,
.login__submit:focus,
.login__submit:hover {
	border-color: #6A679E;
	outline: none;
}

.button__icon {
	font-size: 24px;
	margin-left: auto;
	color: #7875B5;
}

.social-login {	
	position: absolute;
	height: 140px;
	width: 160px;
	text-align: center;
	bottom: 0px;
	right: 0px;
	color: #fff;
}

/* .social-login.h3 {
	font-weight:bold;
	color:white;
} */

.social-icons {
	display: flex;
	align-items: center;
	justify-content: center;
}

.social-login__icon {
	padding: 20px 10px;
	color: #fff;
	text-decoration: none;	
	text-shadow: 0px 0px 8px #7875B5;
}

.social-login__icon:hover {
	transform: scale(1.5);	
}
nav {
	margin-top: 20px;
	width: 100%;
	position: absolute;
	padding: 0% 2%;
	display: flex;
	align-items: center;
	justify-content: space-between;
}

nav .logo {
	width: auto;
	height: 90px; /* Adjust this height as per your need */
	max-width: 100px; /* Optional: ensure it doesn't exceed a certain width */
	opacity: 0.9; /* Slight transparency */
}

nav ul li {
	list-style: none;
	display: inline-block;
	margin-left: 40px;
}

nav ul li a {
	text-decoration: none;
	font-weight:bold;
	color: #333;
	font-size: 17px;
}

nav ul li a:hover {
	text-decoration: none;
	font-weight:bold;
	color: #fff;
}
  </style>
</body>
</html>
