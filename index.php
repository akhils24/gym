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

if(isset($_POST['details'])) {
	$id=$_POST['id'];
	$purid=$_POST['purid'];
	if(isset($_SESSION['userid'])){
		$_SESSION['itemid']= $id;
		$_SESSION['purid']= $purid;
		echo "<script>window.location.href='product.php';</script>";
	}else{
		echo"<script>alert(' Login to view More..!');</script>";
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

    </head>
	
	<body>
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
			font-size: 18px;
			text-decoration: none;
			color: #555;
			font-weight: 400;
			transition: 0.5s;
			}

			.action .menu ul li:hover a {
			color: #5222e0;
			}

		</style>
		<!--welcome-hero start -->
		<section id="home" class="welcome-hero">
			<!-- top-area Start -->
			<div class="top-area">
				<div class="header-area">
					<!-- Start Navigation -->
				    <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy"  data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">
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
									<?php if(isset($_SESSION['userid'])):?>
										<li class="scroll"><a href="#service">services</a></li>
										<li class="scroll"><a href="#new-cars">new Produts</a></li>
										<li class="scroll"><a href="#featured-cars" >featured Products</a></li>
										<li><a href="cart.php">cart</a></li>
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
														<img src="assets/images/user-profile/profile.png"  /><a href="profile.php">My profile</a>
													</li>
													<li>
														<img src="assets/images/user-profile/edit.png" /><a href="orders.php">Orders</a>
													</li>
													<li>
														<img src="assets/images/user-profile/logout.png" /><a href="logout.php">Logout</a>
													</li>
													</ul>
												</div>
											</div>
										</li>
									<?php else:?>
										<li class=" scroll active"><a href="#home">home</a></li>
										<li class="scroll"><a href="#service">service</a></li>
										<li class="scroll"><a href="#new-cars">new Produts</a></li>
										<li class="scroll"><a href="#featured-cars" >featured Products</a></li>
										<li class="scroll"><a href="#contact">contact</a></li>
									<?php endif;?>
				                </ul><!--/.nav -->
				            </div><!-- /.navbar-collapse -->
				        </div><!--/.container-->
				    </nav><!--/nav-->
				    <!-- End Navigation -->
				</div><!--/.header-area-->
			    <div class="clearfix"></div>
			</div><!-- /.top-area-->
			<!-- top-area End -->

			<div class="container">
				<div class="welcome-hero-txt">
					<h2>welcome to <br> Welcare fitness</h2>
					<p>
						From home workouts to serious gym setups, we’ve got the equipment to push your limits!
					</p>
					<?php if(isset($_SESSION['userid'])):?>
					<button class="welcome-btn" onclick="window.location.href='#new-cars'">New-Products</button>
					<?php else: ?>
					<button class="welcome-btn" onclick="window.location.href='login.php'">Login</button>
					<?php endif;?>
				</div>
			</div>
		</section><!--/.welcome-hero-->
		
		<!--service start -->
		<section id="service" class="service" style="margin-top:-200px;">
			<div class="container">
				<div class="service-content">
					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="flaticon-car"></i>
								</div>
								<h2><a href="#">largest dealership <span> of</span> car</a></h2>
								<p>
									Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut den fugit sed quia.  
								</p>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="flaticon-car-repair"></i>
								</div>
								<h2><a href="#">unlimited repair warrenty</a></h2>
								<p>
									Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut den fugit sed quia.  
								</p>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="flaticon-car-1"></i>
								</div>
								<h2><a href="#">insurence support</a></h2>
								<p>
									Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut den fugit sed quia. 
								</p>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.container-->

		</section><!--/.service-->
		<!--service end-->

		<!--new-cars start -->
		<section id="new-cars" class="new-cars">
			<div class="container">
				<div class="section-header">
					<p>checkout <span>the</span> latest products</p>
					<h2>newest products</h2>
				</div><!--/.section-header-->
				<div class="new-cars-content">
					<div class="owl-carousel owl-theme" id="new-cars-carousel">
						<?php
						$itm= mysqli_query($conn,"SELECT * FROM item WHERE item_status=1 ORDER BY item_id DESC limit 3");
						while($row=mysqli_fetch_assoc($itm))
							{
								$subcat=mysqli_query($conn,"SELECT * FROM subcategory WHERE subcat_id = '".$row['subcat_id']."'");
								$subrow=mysqli_fetch_assoc($subcat);
								$cat=mysqli_query($conn,"SELECT * FROM category WHERE cat_id = '".$subrow['cat_id']."'");
								$catrow=mysqli_fetch_assoc($cat);
								$pur=mysqli_query($conn,"SELECT * FROM purchase_child WHERE item_id='".$row['item_id']."' AND stock >0 ORDER BY Pur_child_id ASC limit 1");
								$purrow=mysqli_fetch_assoc($pur);
								echo '<div class="new-cars-item">
									<div class="single-new-cars-item">
										<div class="row">
											<div class="col-md-7 col-sm-12">
												<div class="new-cars-img">
													<img style="height : 300px; width : 300px;" src="data:image/jpeg;base64,' . base64_encode($row['item_image']) . '" alt="' . $row['image_name'] . '">
												</div><!--/.new-cars-img-->
											</div>
											<div class="col-md-5 col-sm-12">
												<div class="new-cars-txt">
													<h2><a href="#"> <span> '.$row['item_name'].'</span></a></h2>

													<h4>Price : '.$purrow['sell_price'].'</h4><br>
													<h4>Stock : '.$purrow['stock'].'</h4>
													<p class="new-cars-para2">'.$row['item_desc'].'</p>
														
													<form method="POST" action=""><input name="id" hidden value="'.$row['item_id'].'"><input name="purid" hidden value="'.$purrow['pur_child_id'].'"><button class="welcome-btn new-cars-btn" type="submit" name="details">view details</button></form>
												</div><!--/.new-cars-txt-->	
											</div><!--/.col-->
										</div><!--/.row-->
									</div><!--/.single-new-cars-item-->
								</div>';
							}
						?>
					</div><!--/#new-cars-carousel-->
				</div><!--/.new-cars-content-->
			</div><!--/.container-->

		</section><!--/.new-cars-->
		<!--new-cars end -->

		<!--featured-cars start -->
		<section id="featured-cars" class="featured-cars">
			<div class="container">
				<div class="section-header">
					<p>checkout <span>the</span> featured Products</p>
					<h2>featured Products</h2>
				</div><!--/.section-header-->
				<div class="featured-cars-content">
					<div class="row">
						<?php
							$itm= mysqli_query($conn,"SELECT * FROM item WHERE item_status=1 ");
							while($row=mysqli_fetch_assoc($itm))
							{
								$subcat=mysqli_query($conn,"SELECT * FROM subcategory WHERE subcat_id = '".$row['subcat_id']."'");
								$subrow=mysqli_fetch_assoc($subcat);
								$cat=mysqli_query($conn,"SELECT * FROM category WHERE cat_id = '".$subrow['cat_id']."'");
								$catrow=mysqli_fetch_assoc($cat);
								$pur=mysqli_query($conn,"SELECT * FROM purchase_child WHERE item_id='".$row['item_id']."' AND stock >0 ORDER BY Pur_child_id ASC limit 1");
								$purrow=mysqli_fetch_assoc($pur);
								echo '<div class="col-lg-3 col-md-4 col-sm-6">
									<div class="single-featured-cars">
										<div class="featured-img-box">
											<div class="featured-cars-img">';
												echo '<img style="height : 200px; width : 200px;" src="data:image/jpeg;base64,' . base64_encode($row['item_image']) . '" alt="' . $row['image_name'] . '">';
												// <img src="assets/images/featured-cars/fc1.png" alt="cars">
											echo '</div>
											<div class="featured-model-info">
												<p>
													category : ' . $catrow['cat_name'].'
													<span class="featured-mi-span"> '.$subrow['subcat_name'].'</span> 
												</p>
											</div>
										</div>
										<div class="featured-cars-txt">
											<h2><a href="#">'.$row['item_name'].'</a></h2>
											<h3>'.$purrow['sell_price'].'</h3>
											<h3>Stock : '.$purrow['stock'].'</h3>
											<p>'.$row['item_desc'].'</p>
											<form method="POST" action=""><input name="id" hidden value="'.$row['item_id'].'"><input name="purid" hidden value="'.$purrow['pur_child_id'].'"><button class="welcome-btn new-cars-btn" type="submit" name="details">view details</button></form>
										</div>
									</div>
								</div>';
							}
						?>
					</div>
				</div>
			</div><!--/.container-->

		</section><!--/.featured-cars-->
		<!--featured-cars end -->

		<!-- clients-say strat -->
		<section id="clients-say"  class="clients-say">
			<div class="container">
				<div class="section-header">
					<h2>what our clients say</h2>
				</div><!--/.section-header-->
				<div class="row">
					<div class="owl-carousel testimonial-carousel">
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c1.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											Sed ut pers unde omnis iste natus error sit voluptatem accusantium dolor laudan rem aperiam, eaque ipsa quae ab illo inventore verit. 
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">tomas lili</a></h2>
										<h4>new york</h4>
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c2.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											Sed ut pers unde omnis iste natus error sit voluptatem accusantium dolor laudan rem aperiam, eaque ipsa quae ab illo inventore verit. 
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">romi rain</a></h2>
										<h4>london</h4>
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c3.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											Sed ut pers unde omnis iste natus error sit voluptatem accusantium dolor laudan rem aperiam, eaque ipsa quae ab illo inventore verit. 
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">john doe</a></h2>
										<h4>washington</h4>
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
					</div><!--/.testimonial-carousel-->
				</div><!--/.row-->
			</div><!--/.container-->

		</section><!--/.clients-say-->	
		<!-- clients-say end -->

		

		<!--contact start-->
		<footer id="contact"  class="contact">
			<div class="container">
				<div class="footer-top">
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<div class="single-footer-widget">
								<div class="footer-logo">
									<a href="index.html">Welcare Fitness</a>
								</div>
								<p>
									Ased do eiusm tempor incidi ut labore et dolore magnaian aliqua. Ut enim ad minim veniam.
								</p>
								<div class="footer-contact">
									<p>info@themesine.com</p>
									<p>+1 (885) 2563154554</p>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-6">
							<div class="single-footer-widget">
								<h2>about devloon</h2>
								<ul>
									<li><a href="#">about us</a></li>
									<li><a href="#">career</a></li>
									<li><a href="#">terms <span> of service</span></a></li>
									<li><a href="#">privacy policy</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-xs-12">
							<div class="single-footer-widget">
								<h2>top brands</h2>
								<div class="row">
									<div class="col-md-7 col-xs-6">
										<ul>
											<li><a href="#">BMW</a></li>
											<li><a href="#">lamborghini</a></li>
											<li><a href="#">camaro</a></li>
											<li><a href="#">audi</a></li>
											<li><a href="#">infiniti</a></li>
											<li><a href="#">nissan</a></li>
										</ul>
									</div>
									<div class="col-md-5 col-xs-6">
										<ul>
											<li><a href="#">ferrari</a></li>
											<li><a href="#">porsche</a></li>
											<li><a href="#">land rover</a></li>
											<li><a href="#">aston martin</a></li>
											<li><a href="#">mersedes</a></li>
											<li><a href="#">opel</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-offset-1 col-md-3 col-sm-6">
							<div class="single-footer-widget">
								<h2>news letter</h2>
								<div class="footer-newsletter">
									<p>
										Subscribe to get latest news  update and informations
									</p>
								</div>
								<div class="hm-foot-email">
									<div class="foot-email-box">
										<input type="text" class="form-control" placeholder="Add Email">
									</div><!--/.foot-email-box-->
									<div class="foot-email-subscribe">
										<span><i class="fa fa-arrow-right"></i></span>
									</div><!--/.foot-email-icon-->
								</div><!--/.hm-foot-email-->
							</div>
						</div>
					</div>
				</div>
			</div><!--/.container-->

			<div id="scroll-Top">
				<div class="return-to-top">
					<i class="fa fa-angle-up " id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
				</div>
				
			</div><!--/.scroll-Top-->
			
        </footer><!--/.contact-->
		<!--contact end-->


		
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
</html>
