<?php
// include('crt-header.php');

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "gym";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if ($conn->connect_error) {
    die("connection Failed: " . $conn->connect_error);
}

session_start();
$userid = $_SESSION['userid'];
$cart_ms=mysqli_query($conn,"SELECT * FROM cart_master WHERE customer_id='$userid' AND cart_status='IN CART'");
if(mysqli_num_rows($cart_ms)>0) {
    $cartm=mysqli_fetch_assoc($cart_ms);
    $cart_master_id=$cartm['cart_master_id'];
}

if(isset($_POST['item-details'])) {
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

if(isset($_POST['back'])) {
    echo "<script>window.location.href='index.php#featured-cars';</script>";
}

if(isset($_POST['qtyminus'])) {
    $itemid=$_POST['item_id'];
    $purqry = "SELECT * FROM purchase_child WHERE item_id = '$itemid' AND stock > 0 ORDER BY Pur_child_id ASC LIMIT 1";
    $item_result=mysqli_query($conn,$purqry);
    $item_row = $item_result->fetch_assoc();
    
    $sql = "UPDATE cart_child SET cart_qty = cart_qty - 1, item_total = item_total - $item_row[sell_price] WHERE cart_master_id = '$cart_master_id' AND item_id = '$itemid'";
    $result = mysqli_query($conn,$sql);

    $sql = "UPDATE cart_master SET cart_tot_amt = cart_tot_amt -  $item_row[sell_price] WHERE cart_master_id = '$cart_master_id'";
    $result = mysqli_query($conn,$sql);

    $cartch_result=mysqli_query($conn,"SELECT * FROM cart_child WHERE cart_master_id = '$cart_master_id' AND item_id = '$itemid'");
    $cartch_row=$cartch_result->fetch_assoc();

    if($cartch_row['cart_qty']==='0') {
        mysqli_query($conn,"DELETE FROM cart_child WHERE cart_child_id = $cartch_row[cart_child_id]");
    }
    
}

if(isset($_POST['qtyplus']))
{
    $itemid=$_POST['item_id'];
    $purchase_id=$_SESSION['purid'];
    $purqry = "SELECT * FROM purchase_child WHERE item_id = '$itemid' AND stock > 0 ORDER BY Pur_child_id ASC LIMIT 1";
    $item_result=mysqli_query($conn,$purqry);
    $item_row=$item_result->fetch_assoc();

    $cartch_result=mysqli_query($conn,"SELECT * FROM cart_child WHERE cart_master_id = '$cart_master_id' AND item_id = '$itemid'");
    $cartch_row=$cartch_result->fetch_assoc();

    if($cartch_row['cart_qty']===$item_row['stock']) {
        echo "<script>alert('You Cannot Add More');</script>"; 
    }
    else {
        $sql = "UPDATE cart_child SET cart_qty = cart_qty + 1, item_total = item_total + $item_row[sell_price] WHERE cart_master_id = '$cart_master_id' AND item_id = '$itemid'";
        $result = mysqli_query($conn,$sql);
    
        $sql = "UPDATE cart_master SET cart_tot_amt = cart_tot_amt +  $item_row[sell_price] WHERE cart_master_id = '$cart_master_id'";
        $result = mysqli_query($conn,$sql);
    }    
    
}

if(isset($_POST['checkout']))
{
    $cart_row=mysqli_query($conn,"SELECT * FROM cart_child WHERE cart_master_id = '$cart_master_id'");
    if(mysqli_num_rows($cart_row)>0) {

        $_SESSION['cartmid']=$cart_master_id;
        echo "<script>window.location.href='payment.php';</script>";
    }else {
        echo "<script>alert('Add Products into the cart to Make Checkout');window.location.href='index.php#featured-cars';</script>"; 
    }
}

if(isset($_POST['remove']))
{
    $itemid=$_POST['item_id'];
    $cartch_result=mysqli_query($conn,"SELECT * FROM cart_child WHERE cart_master_id = '$cart_master_id' AND item_id = '$itemid'");
    $cartch_row=$cartch_result->fetch_assoc();

    $sql = "UPDATE cart_master SET cart_tot_amt = cart_tot_amt -  $cartch_row[item_total] WHERE cart_master_id = '$cart_master_id'";
    $result = mysqli_query($conn,$sql);

    mysqli_query($conn,"DELETE FROM cart_child WHERE cart_child_id = $cartch_row[cart_child_id]");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcare Fitness - Shopping Cart</title>
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favi.png"/>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favi.png"/>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/linearicons.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="assets/css/bootsnav.css" >	
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body style="background: rgb(212, 206, 220);">
<style>

    .btn-name {
        
        background: none;
        border: none;
        margin-left:50px;
        font-weight:bold;
        cursor: pointer;
    }
    .qtysize {
        background: none;
        border: none;
        font-weight:bold;
        font-size:20px; 
        cursor: pointer;
    }
    /* Navbar and Profile Dropdown Styling */
    .action {
        position: relative;
        z-index: 999;
        font-family: "Poppins", sans-serif;
        position: fixed;
        top: 30px;
        right: 100px;
    }

    .action .profile {
    position: absolute;
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
    right: -5px;
    /* left : -50; */
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
    /* margin-left:-30px; */
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
    font-size: 15px;
    color: #555;
    font-weight: 400;
    transition: 0.5s;
    }

    .action .menu ul li:hover a {
    color: #5222e0;
    }

</style>

    <!-- Navigation Bar -->
    <section id="home">
        <div class="top-area" >
            <div class="header-area">
                <nav class="navbar navbar-default bootsnav navbar-sticky navbar-scrollspy" style="background-color: #000; box-shadow: 0 2px 5px;" data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">
                    <div class="container" style="height:80px;">
                        <div class="navbar-header col-4">
                            <a class="navbar-brand" href="index.php">
                                <img style="margin-top: -50px; height: 100px;" src="assets/logo/logo-new.png" class="frontlogo">
                            </a>
                        </div>
                        <div id="navbar-menu " class="col-6" >
                            <ul class="nav navbar-nav navbar-right list-group-horizontal " data-in="fadeInDown" data-out="fadeOutUp" >
                                <li style="margin-top:-50px;margin-right:0px;text-decoration: none;"><a href="index.php" style="text-decoration: none;">Home</a></li>
                                <li style="margin-top:-50px;margin-left:0px;"><a href="index.php#featured-cars" style="text-decoration: none;">Featured Products</a></li>
                                <li style="margin-top:-50px; margin-right:-200px;"><a href="cart.php" style="text-decoration: none;">Cart</a></li>
                                <li style="margin-left:-20px;">
                                    <?php
                                    $usqry = mysqli_query($conn, "SELECT * FROM customer WHERE customer_id =" . $_SESSION['userid']);
                                    $us = mysqli_fetch_assoc($usqry);
                                    ?>
                                    <div class="action">
                                        <div class="profile" onclick="menuToggle();">
                                            <img src="assets/images/user.png" style="height:35px; width:35px;" alt="User Image" />
                                        </div>
                                        <div class="menu">
                                            <h3><?php echo $us['c_fname'] . ' ' . $us['c_lname']; ?><br /><span><?php echo $us['username']; ?></span></h3>
                                            <ul>
                                                <li><img src="assets/images/user-profile/profile.png" /><a href="profile.php">My profile</a></li>
                                                <li><img src="assets/images/user-profile/edit.png" /><a href="orders.php">Orders</a></li>
                                                <li><img src="assets/images/user-profile/logout.png" /><a href="logout.php">Logout</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </section>
    
   <section id="service" class="service" style="margin-top:-150px;">
        <div class="container px-3 my-5">
            <form action=" " method="POST">
                <div class="card">
                    <div class="card-header">
                        <h2>SHOPPING CART</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered m-0">
                                <thead>
                                    <tr>
                                        <th class="text-center py-3 px-4" style="min-width: 400px;">Product Name &amp; Details</th>
                                        <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                                        <th class="text-center py-3 px-4" style="width: 100px;">Quantity</th>
                                        <th class="text-right py-3 px-4" style="width: 100px;">Total</th>
                                        <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="Clear cart"><i class="ion ion-md-trash"></i></a></th>
                                    </tr>
                                </thead>
                                <?php
                                $crtms = mysqli_query($conn, "SELECT * FROM cart_master WHERE customer_id='$userid' AND cart_status='IN CART'");
                                $cartExists = mysqli_num_rows($crtms) > 0;
                                if ($cartExists):
                                    $cartmas_result = $crtms->fetch_assoc();
                                    $crtch = mysqli_query($conn, "SELECT * FROM cart_child WHERE cart_master_id=$cartmas_result[cart_master_id]");
                                    $cartchExists = mysqli_num_rows($crtch) > 0;
                                    while ($row = $crtch->fetch_assoc()):
                                        $purqry = "SELECT * FROM purchase_child WHERE item_id = $row[item_id] AND stock > 0 ORDER BY Pur_child_id ASC LIMIT 1";
                                        $purcon = mysqli_query($conn, $purqry);
                                        $purresult = $purcon->fetch_assoc();
                                        $itm = mysqli_query($conn, "SELECT * FROM item WHERE item_id=$row[item_id]");
                                        $result = $itm->fetch_assoc();
                                ?>
                                <tbody>
                                    <tr>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <?php echo '<img class="d-block ui-w-40 ui-bordered mr-4" style="height:100px; width:100px;" src="data:image/jpeg;base64,' . base64_encode($result['item_image']) . '" alt="' . $result['image_name'] . '">'; ?>
                                                <div class="media-body">
                                                    <form action='' method='POST'><?php echo "<input name='id' hidden value='" . $row['item_id'] . "'><input name='purid' hidden value='".$row['purch_id']."'>"; ?><button type="submit" name="item-details" class="btn-name"><?php echo $result['item_name']; ?></button></form>
                                                </div>
                                                <h6>In Stock: <?php echo $purresult['stock']; ?></h6>
                                            </div>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4"><?php echo $purresult['sell_price']; ?></td>
                                        <td class="text-center align-middle px-0">
                                            <form action='cart.php' method='POST'><?php echo "<input type='hidden' name='item_id' value='" . $row['item_id'] . "'>"; ?>
                                                <button class="qtysize" name="qtyminus">-</button>
                                                <?php echo $row['cart_qty']; ?>
                                                <button class="qtysize" name="qtyplus">+</button>
                                            </form>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4"><?php echo $row['item_total']; ?></td>
                                        <td class="text-center align-middle px-0"><form action='' method='POST'><?php echo "<input type='hidden' name='item_id' value='" . $row['item_id'] . "'>"; ?><button class="shop-tooltip close float-none text-danger" name="remove" type="submit">×</button></form></td>
                                    </tr>
                                </tbody>
                                <?php endwhile;?>
                                <?php endif; ?>
                                <?php if(!$cartExists || !$cartchExists ): ?>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center p-4 font-weight-bold">No items in the cart</td>
                                        </tr>
                                    </tbody>
                                <?php endif; ?>
                            </table>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                            <label class="text-muted font-weight-normal m-0">Grand Total:</label>
                            <?php if(mysqli_num_rows($crtms)>0): ?>
                                <div class="text-large"><strong><?php echo "$cartmas_result[cart_tot_amt]"; ?>/-</strong></div>
                            <?php else: ?>
                                <div class="text-large"><strong>0/-</strong></div>
                            <?php endif; ?>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3" name="back">Back to shopping</button>
                            <button type="submit" name="checkout" class="btn btn-lg btn-primary mt-2">Checkout</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="assets/js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootsnav.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/custom.js"></script>

    <script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>