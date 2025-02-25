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

if(isset($_POST['save-edit'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob = $_POST['date'];
    $phoneNumber = $_POST['phone'];
    $district = $_POST['district'];
    $pincode = $_POST['pin'];
    $place = $_POST['place'];

    $custqry= "UPDATE customer SET c_fname = '$firstName',c_lname = '$lastName',c_phno = '$phoneNumber',c_place = '$place',c_dist = '$district',C_pincode = '$pincode',c_gender = '$gender',c_dob = '$dob' WHERE customer_id='$userid'";
    mysqli_query($conn,$custqry);
    echo "<script>alert('Details of ".$firstName." have been Updated successfully!');window.location.href='profile.php'</script>";

}
?>

<!DOCTYPE html>
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
    </style>


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
                </ul>
            </div>
        </div>
    </nav>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?php echo $us['c_fname']." ".$us['c_lname'];?></span><span class="text-black-50"><?php echo $us['username'];?></span><span> </span></div>
            </div>
            <div class="col-md-8 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form method="POST" action="">
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" placeholder="first name" value="<?php echo $us['c_fname'];?>" name="first_name"></div>
                            <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control" value="<?php echo $us['c_lname'];?>" placeholder="surname" name="last_name"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Mobile Number</label><input type="text" class="form-control" placeholder="enter phone number" value="<?php echo $us['c_phno'];?>" name="phone" ></div>
                            <div class="col-md-6"><label class="labels">Gender</label><input type="text" class="form-control" placeholder="enter Gender" value="<?php echo $us['c_gender'];?>" name="gender"></div>
                            <div class="col-md-6"><label class="labels">Email ID</label><input type="text" class="form-control" placeholder="enter email id" value="<?php echo $us['username'];?>" name="email" readonly></div>
                            <div class="col-md-6"><label class="labels">Date Of Birth</label><input type="date" class="form-control" placeholder="DOB" value="<?php echo $us['c_dob'];?>" name="date"></div>
                            <div class="col-md-6"><label class="labels">Place</label><input type="text" class="form-control" placeholder="enter Place" value="<?php echo $us['c_place'];?>" name="place"></div>
                            <div class="col-md-6"><label class="labels">District</label><input type="text" class="form-control" placeholder="enter District" value="<?php echo $us['c_dist'];?>" name="district"></div>
                            <div class="col-md-6"><label class="labels">Pincode</label><input type="text" class="form-control" placeholder="enter Pincodde" value="<?php echo $us['c_pincode'];?>" name="pin"></div>
                            <!-- <div class="col-md-6"><label class="labels">State</label><input type="text" class="form-control" placeholder="enter State" value=""></div> -->
                        </div>
                        <!-- <div class="row mt-3">
                            <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" value=""></div>
                            <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" value="" placeholder="state"></div>
                        </div> -->
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" type="submit" name="save-edit" >Save Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>
</body>
</html>
<style>
    body {
    background: rgb(212, 206, 220);
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

