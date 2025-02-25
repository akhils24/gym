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

$crt = mysqli_query($conn, "SELECT * FROM cart_master WHERE customer_id = '$userid' AND cart_status='IN CART'");
if ($crt && $crt->num_rows > 0) {
    $cartm = $crt->fetch_assoc();
    $cart_mast_id = $cartm['cart_master_id'];
    $cartc = mysqli_query($conn, "SELECT * FROM cart_child WHERE cart_master_id = '$cart_mast_id' AND item_id = '$id'");
    if ($cartc && $cartc->num_rows > 0) {
        $cartc = $cartc->fetch_assoc();
        $incart = $cartc['cart_qty'];
    } else {
        $incart = 0;
    }
} else {
    $incart = 0;
}


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

if(isset($_POST['cart'])) {
    $id=$_POST['id'];
	$purid=$_POST['purid'];
    $qty=$_POST['qty'];
    $userid=$_SESSION['userid'];
    $purchase_child=mysqli_query($conn,"SELECT * FROM purchase_child WHERE pur_child_id='$purid'");
    $purchase_res=mysqli_fetch_assoc($purchase_child);
    $sell_price=$purchase_res['sell_price'];
    $tot_price=$qty*$sell_price;

    $sql="SELECT * FROM cart_master WHERE customer_id = '$userid' AND cart_status='IN CART'";
    $res=mysqli_query($conn,$sql);
    mysqli_begin_transaction($conn);
    try{
        if(mysqli_num_rows($res) == 0){
            $res=mysqli_query($conn,"INSERT INTO cart_master(customer_id,cart_status,cart_tot_amt)VALUES('$userid','IN CART','$tot_price')");
            $cart_mast_id = mysqli_insert_id($conn);
            $sql="INSERT INTO cart_child(cart_master_id,item_id,cart_qty,item_rate,item_total,purch_id)VALUES('$cart_mast_id','$id','$qty','$sell_price','$tot_price','$purid')";
            $res=mysqli_query($conn,$sql);
            echo "<script>alert('Item Added to the cart ');window.location.href='product.php';</script>";
        }else{
            $cartm=mysqli_fetch_assoc($res);
            $cart_mast_id=$cartm['cart_master_id'];
            $sql=mysqli_query($conn,"SELECT * FROM cart_child WHERE cart_master_id='$cart_mast_id' AND item_id ='$id' AND purch_id='$purid'");
            if(mysqli_num_rows($sql) == 1){
                $cart_child=$sql->fetch_assoc();
                $cart="UPDATE cart_child SET cart_qty=cart_qty+ '$qty' , item_total=item_total+'$tot_price' WHERE cart_child_id = '".$cart_child['cart_child_id']."'";
                mysqli_query($conn,$cart);
                $cartm="UPDATE cart_master SET cart_tot_amt = cart_tot_amt + '$tot_price' WHERE cart_master_id ='$cart_mast_id'";
                mysqli_query($conn,$cartm);
                echo "<script>alert('Quantity Updated in the cart ');window.location.href='product.php';</script>";
            }else {
                $sql="INSERT INTO cart_child(cart_master_id,item_id,cart_qty,item_rate,item_total,purch_id)VALUES('$cart_mast_id','$id','$qty','$sell_price','$tot_price','$purid')";
                $res=mysqli_query($conn,$sql);
                $cartm="UPDATE cart_master SET cart_tot_amt = cart_tot_amt + '$tot_price' WHERE cart_master_id ='$cart_mast_id'";
                mysqli_query($conn,$cartm);
                echo "<script>alert('Item Added to the cart ');window.location.href='product.php';</script>";
            }
        }
        mysqli_commit($conn);
    }catch(Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Item Failed to add to the cart ');window.location.href='index.php';</script>";
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
            text-decoration: none;
            color: #555;
            font-weight: 500;
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
				    <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy" style="background-color: #000;box-shadow: 0 2px 5px rgba(0,0,0,.2); height : 100px;" data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">
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
				            <div class="collapse navbar-collapse menu-ui-design" >
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
				                </ul><!--/.nav -->
				            </div><!-- /.navbar-collapse -->
				        </div><!--/.container-->
				    </nav><!--/nav-->
				    <!-- End Navigation -->
				</div><!--/.header-area-->
			    <div class="clearfix"></div>
			</div><!-- /.top-area-->
			<!-- top-area End -->
		</section><!--/.welcome-hero-->
        <div class="clearfix"></div><br>

		<section class="new-cars">
			<div class="container">
				<div class="section-header">
					<!-- <p>checkout <span>the</span> product</p> -->
					<h2>Product  Details</h2>
				</div><!--/.section-header-->
				<div class="new-cars-content">
                    <?php
                    $itm= mysqli_query($conn,"SELECT * FROM item WHERE item_id=$id");
                    $row=mysqli_fetch_assoc($itm);
                    $subcat=mysqli_query($conn,"SELECT * FROM subcategory WHERE subcat_id = '".$row['subcat_id']."'");
                    $subrow=mysqli_fetch_assoc($subcat);
                    $cat=mysqli_query($conn,"SELECT * FROM category WHERE cat_id = '".$subrow['cat_id']."'");
                    $catrow=mysqli_fetch_assoc($cat);
                    $pur=mysqli_query($conn,"SELECT * FROM purchase_child WHERE pur_child_id=$purid");
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
                                        <h4>Stock : '.$purrow['stock'].'</h4><br>
                                        <h4>In Cart : '.$incart.'</h4><br>';
                                        if($purrow['stock']>0){
                                            $max=$purrow['stock']-$incart;
                                            echo'<form method="POST" action="">
                                            <h5>Qty : <input name="qty" type="number" style="width:50px;" max='.$max.' min="0" value="0"></h5>
                                            <p class="new-cars-para2">'.$row['item_desc'].'</p>
                                            <input name="id" hidden value="'.$row['item_id'].'"><input name="purid" hidden value="'.$purrow['pur_child_id'].'"><button class="welcome-btn new-cars-btn" type="submit" name="cart">Add To Cart</button></form>';
                                        }else{
                                            echo'
                                            <h5>Qty : <input name="qty" type="number" style="width:50px;" max='.$purrow['stock'].' min="0" value="0"></h5>
                                            <p class="new-cars-para2">'.$row['item_desc'].'</p>
                                            <input name="id" hidden value="'.$row['item_id'].'"><input name="purid" hidden value="'.$purrow['pur_child_id'].'"><button style="color:grey" class="welcome-btn new-cars-btn" type="submit" >Out of Stock</button>';
                                        }
                                        echo'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                    ?>
				</div>
			</div>
		</section>

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
								$purcnt=mysqli_num_rows($pur)>0;
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
											<h2><a href="#">'.$row['item_name'].'</a></h2>';
											if($purcnt)
											{
												echo '<h3>'.$purrow['sell_price'].'</h3>
												<h3>Stock : '.$purrow['stock'].'</h3>
												<p>'.$row['item_desc'].'</p>
												<form method="POST" action=""><input name="id" hidden value="'.$row['item_id'].'"><input name="purid" hidden value="'.$purrow['pur_child_id'].'"><button class="welcome-btn new-cars-btn" type="submit" name="details">view details</button></form>';
											}else{
												echo '<h3>'." ".'</h3>
												<h3>Stock : 0</h3>
												<p>'.$row['item_desc'].'</p>
												<button class="welcome-btn new-cars-btn" type="submit" name="details">Out Of Stock</button>';
											}echo'
										</div>
									</div>
								</div>';
							}
						?>
					</div>
				</div>
			</div><!--/.container-->

		</section>

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
