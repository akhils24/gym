
<?php
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$db="gym";
//Create Connection
$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$db);
//Check Connection
if($conn->connect_error)
{
     die("connection Failed : ".$conn->connect_error);
}
// echo"Connected successfully";

session_start();

$id = $_SESSION['itemid'];
$purid = $_SESSION['purid'];
$userid=$_SESSION['userid'];
?>

<!doctype html>
<html class="no-js" lang="en">

    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!--font-family-->
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		<link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">
        
        <!-- title of site -->
        <title>Welcare Fitness</title>

        <!-- For favicon png -->
		<link rel="shortcut icon" type="image/icon" href="assets/logo/favi.png"/>
       
        <!--font-awesome.min.css-->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!--linear icon css-->
		<link rel="stylesheet" href="assets/css/linearicons.css">

        <!--flaticon.css-->
		<link rel="stylesheet" href="assets/css/flaticon.css">

		<!--animate.css-->
        <link rel="stylesheet" href="assets/css/animate.css">
   
        <!--owl.carousel.css-->
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
		
        <!--bootstrap.min.css-->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- bootsnav -->
		<link rel="stylesheet" href="assets/css/bootsnav.css" >	
        
        <!--style.css-->
        <link rel="stylesheet" href="assets/css/style.css">
        
        <!--responsive.css-->
        <link rel="stylesheet" href="assets/css/responsive.css">

        <!-- for user drop down -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />


        <!-- cart -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

    </head>
	
	<body style="background: rgb(212, 206, 220);" >

    <section id="home">
        <div class="top-area">
            <div class="header-area">
                <!-- Start Navigation -->
                <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy" style="background-color: #000;box-shadow: 0 2px 5px rgba(0,0,0,.2);"  data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">
                    <div class="container">
                        <!-- Start Header Navigation -->
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index.php">
                                <img  style=" margin-top :-30px; height: 100px;" src="assets/logo/logo-new.png" class="frontlogo">
                                <span></span>
                            </a>
                        </div><!--/.navbar-header-->
                        <!-- End Header Navigation -->

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                                <li><a href="index.php">home</a></li>
                                <li class="scroll"><a href="#featured-cars" >featured Products</a></li>
                                <li><a href="cart.php" >cart</a></li>
                                <li>
                                    <?php
                                        $usqry=mysqli_query($conn,"SELECT * FROM customer WHERE customer_id =" .$_SESSION['userid']); 
                                        $us=mysqli_fetch_assoc($usqry); 
                                    ?>
                                    <div class="action">
                                        <div class="profile" onclick="menuToggle();">
                                            <img src="assets/images/user.png" style="height:35px; width:35px;" alt="image of clients person" />
                                        </div>
                                        <div class="menu">
                                            <h3><?php echo $us['c_fname'].' '.$us['c_lname']; ?><br /><span><?php echo $us['username']; ?></span></h3>
                                            <ul>
                                            <li>
                                                <img src="assets/images/user-profile/profile.png"  /><a href="Orders.php">Orders</a>
                                            </li>
                                            <li>
                                                <img src="assets/images/user-profile/edit.png" /><a href="#">Edit profile</a>
                                            </li>
                                            <li>
                                                <img src="assets/images/user-profile/logout.png" /><a href="logout.php">Logout</a>
                                            </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                        </ul><!--/.nav -->
                        </div><!-- /.navbar-collapse -->
                    </div><!--/.container-->
                </nav><!--/nav-->
                <!-- End Navigation -->
            </div><!--/.header-area-->
            <div class="clearfix"></div>

        </div>

        
		
    <!-- Include all js compiled plugins (below), or include individual files as needed -->

    <script src="assets/js/jquery.js"></script>
    
    <!--modernizr.min.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    
    <!--bootstrap.min.js-->
    <script src="assets/js/bootstrap.min.js"></script>
    
    <!-- bootsnav js -->
    <script src="assets/js/bootsnav.js"></script>

    <!--owl.carousel.js-->
    <script src="assets/js/owl.carousel.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!--Custom JS-->
    <script src="assets/js/custom.js"></script>

    <script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>
    </body>
<style>
    .action {
  font-family: "Poppins", sans-serif;
  position: fixed;
  top: 30px;
  right: 100px;
}

.action .profile {
  position: relative;
  width: 60px;
  height: 60px;
  /* border-radius: 50%; */
  overflow: hidden;
  cursor: pointer;
}

.action .profile img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.action .menu {
  position: absolute;
  top: 120px;
  right: -10px;
  padding: 10px 20px;
  background: #fff;
  width: 200px;
  box-sizing: 0 5px 25px rgba(0, 0, 0, 0.1);
  border-radius: 15px;
  transition: 0.5s;
  visibility: hidden;
  opacity: 0;
}

.action .menu.active {
  top: 80px;
  visibility: visible;
  opacity: 1;
}

.action .menu::before {
  content: "";
  position: absolute;
  top: -5px;
  right: 28px;
  width: 20px;
  height: 20px;
  background: #fff;
  transform: rotate(45deg);
}

.action .menu h3 {
  width: 100%;
  text-align: center;
  font-size: 18px;
  padding: 20px 0;
  font-weight: 500;
  color: #555;
  line-height: 1.5em;
}

.action .menu h3 span {
  font-size: 14px;
  color: #cecece;
  font-weight: 300;
}

.action .menu ul li {
  list-style: none;
  padding: 16px 0;
  border-top: 1px solid rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
}

.action .menu ul li img {
  max-width: 20px;
  margin-right: 10px;
  opacity: 0.5;
  transition: 0.5s;
}

.action .menu ul li:hover img {
  opacity: 1;
}

.action .menu ul li a {
  display: inline-block;
  text-decoration: none;
  color: #555;
  font-weight: 500;
  transition: 0.5s;
}

.action .menu ul li:hover a {
  color: #5222e0;
}
</style>