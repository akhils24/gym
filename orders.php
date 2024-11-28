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

$userid=$_SESSION['userid'];

$sql=mysqli_query($conn,"SELECT * FROM customer WHERE customer_id='".$userid."'");
$us=mysqli_fetch_assoc($sql);
?>

<!DOCTYPE html>
<html lang="en">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Welcare Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favi.png"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css" integrity="sha384-jbCTJB16Q17718YM9U22iJkhuGbS0Gd2LjaWb4YJEZToOPmnKDjySVa323U+W7Fv" crossorigin="anonymous">
     -->
<style>
    .navbar {
        background-color: #000;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        height: 100px;
    }

    .navbar-brand img {
        margin-top:0px;
        height: 100px;
    }
    
    .nav-link {
        color: #fff;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: #2020e7;
    }

    .nav-item {
        padding: 10px;
    }

    body {
    background: rgb(212, 206, 220);
    }

    .shadow-custom {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .profile-card img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .order-card {
        border-left: 5px solid #0d6efd;
    }
    .order-card h6 {
        font-weight: bold;
    }
    .order-card p {
        font-size: 14px;
        margin: 0;
    }
    .btn-outline-custom {
        border-color: #0d6efd;
        color: #0d6efd;
    }
    .btn-outline-custom:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #BA68C8
    }

    .profile-button {
        background: rgb(11, 84, 188);
        box-shadow: none;
        border: none
    }

    .profile-button:hover {
        background: #682773
    }

    .profile-button:focus {
        background: #682773;
        box-shadow: none
    }

    .profile-button:active {
        background: rgb(11, 84, 188);
        box-shadow: none
    }

    .back:hover {
        color: rgb(11, 84, 188);
        cursor: pointer
    }

    .labels {
        font-size: 11px
    }

    .add-experience:hover {
        background: #BA68C8;
        color: #fff;
        cursor: pointer;
        border: solid 1px #BA68C8
    }
    .action {
    font-family: "Poppins", sans-serif;
    position: fixed;
    top: 30px;
    right: 20px;
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
<script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-scrollspy sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/logo/logo-new.png" alt="Welcare Fitness Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#featured-cars">FEATURED PRODUCTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">CART</a>
                    </li>
                    <li>
                        
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
                </ul>
            </div>
        </div>
    </nav>
    <div class="container rounded  px-5 mt-5 mb-5">
        <div class="row ml-5">
            <div class="col-md-12 ">
                <div class="card shadow-custom p-4 bg-white">
                    <h4 class="font-weight-bold mx-auto" >Past Orders</h4><br>
                    <?php
                    $sql = mysqli_query($conn, "SELECT * FROM cart_master WHERE customer_id = $userid AND cart_status != 'IN CART'");
                    if (mysqli_num_rows($sql) > 0):
                        while ($row = mysqli_fetch_assoc($sql)):
                            $cartmid = $row['cart_master_id'];
                            $tot = $row['cart_tot_amt'];
                            $paysql = mysqli_query($conn, "SELECT * FROM payment WHERE cart_master_id = $cartmid");
                            $pay = mysqli_fetch_assoc($paysql);
                            $invoiceid = 10000 + $pay['pay_id'];
                            $orderdate = $pay['pay_date'];
                            $status = $row['cart_status'];
                    ?>
                        <div class="card mb-4 order-card p-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>ORDER ID: <?php echo $invoiceid; ?></h6>
                                <span class="text-muted">Ordered on <?php echo $orderdate; ?></span>
                            </div>
                            <hr>
                            <?php
                            $cartchrow = mysqli_query($conn, "SELECT * FROM cart_child WHERE cart_master_id = $cartmid");
                            while ($cartchild = mysqli_fetch_assoc($cartchrow)):
                                $itmid = $cartchild['item_id'];
                                $itm = mysqli_query($conn, "SELECT * FROM item WHERE item_id = $itmid");
                                $itmrow = mysqli_fetch_assoc($itm);
                            ?>
                            <div class="d-flex justify-content-between align-items-center px-4">
                                <p class="mt-0"><strong><?php echo $itmrow['item_name']; ?></strong></p>
                                <p class="mt-1">  Qty: <?php echo $cartchild['cart_qty']; ?></p>
                            </div>
                            <?php endwhile; ?>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Status : <?php echo $status; ?></h6>
                                <form action=" " method="POST">
                                    <input type="hidden" name="cartmid" value="<?php echo $cartmid; ?>">
                                    <button name="invoice" class="btn btn-outline-custom btn-sm">
                                        <i class="icofont-headphone-alt"></i> Invoice
                                    </button>
                                </form>
                                <span class="text-primary"><strong>Total Paid:</strong> $<?php echo $tot; ?></span>
                            </div>
                        </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


