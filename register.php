<?php 
include('head.php');
if(isset($_POST['register'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['date'];
    $phoneNumber = $_POST['phone'];
    $district = $_POST['district'];
    $pincode = $_POST['pin'];
    $place = $_POST['place'];
    $passwordright = $_POST['rightpassword'];
    $passwordleft = $_POST['leftpassword'];

    if(trim($passwordleft) == trim($passwordright)) {
          $lgn=mysqli_query($conn,"SELECT * FROM login WHERE username='$email'");
          if(mysqli_num_rows($lgn)) {
            echo "<script>alert('Username has already been used !');window.location.href='register.php';</script>";
          } else {
            mysqli_begin_transaction($conn);
            try {
                $lgqry= "INSERT INTO login(username,password,user_type)VALUES('$email','$passwordleft','CU')";
                mysqli_query($conn,$lgqry);
                $custqry= "INSERT INTO customer(username,c_fname,c_lname,c_phno,c_place,c_dist,C_pincode,c_gender,c_dob)VALUES('$email','$firstName','$lastName','$phoneNumber','$place','$district','$pincode','$gender','$dob')";
                mysqli_query($conn,$custqry);
                mysqli_commit($conn);
                echo "<script>alert('Details of ".$firstName." have registered successfully!');window.location.href='index.php';</script>";
            } catch(Exception $e) {
                mysqli_rollback($conn);
                echo "<script>alert('Registration Failed due to some issues. Please try again !');window.location.href='register.php';</script>";
            }
          }
    }else {
        echo "<script>alert('Your Passwords don\'t match !');</script>";
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- meta data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer register</title>
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
	<div class="start">
        <!-- <h1 style="color: #000;">Customer Registration</h1> -->
        <br>
		<div class="form">
			<form class="form-detail" action="" method="POST">
				<div class="form-left">
					<h2 id="left">General Information</h2>
					<div class="form-group">
						<div class="form-row" id="row1">
							<input type="text" name="first_name" id="first_name" placeholder="First Name" required>
						</div>
						<div class="form-row" id="row2">
							<input type="text" name="last_name" id="last_name"  placeholder="Last Name" required>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row" id="row1">
							<select name="gender">
								<option value="" disabled selected hidden>Select Gender</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Other">Other</option>
							</select>
						</div>
						<div class="form-row" id="row2">
							<input type="date" style="color: #fff;" name="date" id="date" placeholder="DOB" required>
						</div>
					</div>
					<div class="form-row">
						<input type="email" name="email"  id="email" placeholder="Your Email" required>
					</div>
					<div class="form-group">
						<div class="form-row" id="row1">
							<input type="password" name="leftpassword"  id="password" placeholder="New Password" required>
						</div>
						<div class="form-row" id="row2">
							<input type="password" name="rightpassword"  id="password" placeholder="Repeat Password" required>
						</div>
					</div>
				</div>
				<!-- The right blue Portion -->
				<div class="form-right">
					<h2 id="right">Contact Details</h2>
					<div class="form-row">
						<input type="number" name="phone" id="phone" placeholder="Phone Number" required>
					</div>
					<div class="form-group">
						<div class="form-row" id="row3">
							<input type="int" name="pin" id="pin" placeholder="Pin Code" required>
						</div>
						<div class="form-row" id="row4">
							<input type="text" name="place" id="place" placeholder="Place" required>
						</div>
					</div>
                    <div class="form-row">
							<input type="text" name="district" id="District" placeholder="District" required>
					</div>
					<div class="form-row-last">
						<input class="register" type="submit" name="register" value="Register ">
					</div>
				</div>
			</form>
		</div>
	</div>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
        
        body{
            margin: 0 0 0 0;
            background: linear-gradient(90deg, #C7C5F4, #776BCC);
            /* background-image: url("pxfuel\ \(1\).jpg"); */
            background-size:cover;
            background-position: center;
        } 
        .start {
            margin-top: 150px;
            /* margin:  20px; */
            /* background: #75e2e9; */
            display: flex;
            justify-content: center;
            align-items: center;
            /* background-image:linear-gradient( 136deg, rgb(149,153,226) 0%, rgb(139,198,236) 100%); */
        
        }
        .form  {
            background: #fff;
            width: 999px;
            height: 470px;
            border-radius: 20px;
            margin: 20px 0;
            position: relative;
            font-family: 'Montserrat', sans-serif;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: #fff;
            margin-top: -64px;
        }
        .form-detail {
            position: relative;
            width: 101%;
            display: flex;  
        }
        h1{
            font-family: 'Poppins',sans-serif;
            padding-left: 560px;
            color: #1e6bd6;
            margin-top: 120;	
        }
         h2 {
            font-family:Verdana, Geneva, Tahoma, sans-serif;
            font-weight: 500;
            font-size: 25px;
            margin-bottom: 34px;
            padding: 30px 0px 0px 60px;
            color: #000;
        }
        #left {
            color: #1e6bd6;
        }
        
        p{
            padding-left: 690px;
        }
        .form-left {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            width: 100%;
        }
         .form-right {
            width: 100%;
            background: #fff;
            /* border-bottom-left-radius: 10px; */
            border-bottom-right-radius: 20px;
            border-top-right-radius: 20px;
        }
        
        .form-group {
            display: flex;
            display: -webkit-flex; 
        }
        .form-row {
            position: relative;
            margin-bottom: 24px;
            padding-left: 60px;
             padding-right: 50px;
        }
        #row1 {
            width: 50%;
            padding: 0 12px 0 60px;
        }
        #row2 {
            width: 50%;
            padding: 0 50px 0 12px;
        }
        #row3{
            width: 50%;
            padding: 0 12px 0 60px;
        }
        #row4{
            width: 100%;
            padding: 0 50px 0 12px;
        }
        #submit
        {
            background-color: #1e6bd6;
        }
        
        .form .form-detail select,
        .form .form-detail input {
            width: 100%;
            padding: 11.5px 15px 15px 15px;
            border: 1px solid transparent;
            background: transparent;
            outline: none;
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
        
        }
        .form-left input {
            color: black;
        }
        .form-left input::placeholder{
            color:white;
                font-size: 16px;
        }
        .form-right input {
            color: black;
        }
        .form-right input::placeholder{
            color: grey;
            font-size: 16px;
        }
        .form .form-detail .form-left input,
        .form .form-detail .form-left select {
            border-bottom: 2px solid white;
        }
        .form .form-detail .form-left input:focus,
        .form .form-detail .form-left select:focus {
            border-bottom: 2px solid #151515;
        }
        .form .form-detail .form-right input,
        .form .form-detail .form-right select {
            border-bottom: 2px solid black;
        }
        .form .form-detail .form-right input:focus,
        .form .form-detail .form-right select:focus {
            border-bottom: 2px solid darkolivegreen;
        }
        .form-row-last {
            padding-left: 250px;
            margin: 44px 0 10px;
        }
         .form-detail .form-right .register {
            background: #333;
            border-radius: 40px;
            width: 150px;
            border: none;
            margin: 6px 0 50px 0px;
            cursor: pointer;
            color: #fff;
            font-weight: 700;
            font-size: 15px;
        }
        .form-right .register:hover {
            background: #ccc;
            color:black;
            font-weight: 700;
            font-size: 15px;
        }
        
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0; 
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
            color: #333;
            font-size: 17px;
        }

        nav ul li a:hover {
            color: #fff;
        }

    </style>
</body>
</html>