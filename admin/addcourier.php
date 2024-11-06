<?php
include('header.php');
if(isset($_POST['submit'])) {
  $firstName = $_POST['name'];
  $email = $_POST['email'];
  $pin = $_POST['pin'];
  $phoneNumber = $_POST['phno'];
  $district = $_POST['dist'];
  $place = $_POST['city'];
  if($_SESSION['usertype'] == 'AD'){
    $staffid='000';
  }else{
    $staffid=$_SESSION['userid'];
  }
  $lgn=mysqli_query($conn,"SELECT * FROM login WHERE username='$email'");
  if(mysqli_num_rows($lgn)) {
    echo "<script>alert('Username has already been used !');window.location.href='addcourier.php';</script>";
  } else {
    mysqli_begin_transaction($conn);
    try {
      $lgqry= "INSERT INTO login(username,password,user_type)VALUES('$email','123','CR')";
      mysqli_query($conn,$lgqry);
      $crfqry= "INSERT INTO courier(username,staff_id,co_name,co_phone,co_city,co_dist,co_pin)VALUES('$email','$staffid','$firstName','$phoneNumber','$place','$district','$pin')";
      mysqli_query($conn,$crfqry);
      mysqli_commit($conn);
      echo "<script>alert('Details of the Company ".$firstName." have registered successfully!');window.location.href='courier.php';</script>";
    } catch(Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Registration Failed due to some issues. Please try again !');";
    }
  }
}
?>
<div class="container">
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">ADD NEW COURIER COMPANY</div>
                </div>
                <form method="POST" action="">
                    <div class="card-body" style="width:auto;">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="email2">Email Address</label>
                                    <input type="email" class="form-control" id="email2" placeholder="Enter the Email address" name="email" />
                                </div>
                                <div class="form-group">
                                    <label for="name">Courier Company Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter the Company Name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="phno">Phone Number</label>
                                    <input type="phone" class="form-control" id="phno" placeholder="Enter the Phone Number" name="phno"/>
                                </div>
                                <div class="form-group">
                                    <label for="City">City</label>
                                    <input type="text" class="form-control" id="City" placeholder="Enter the City" name="city" />
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">                                    
                                <div class="form-group">
                                    <label for="dist">District</label>
                                    <input type="text" class="form-control" id="dist" placeholder="Enter the District" name="dist" />
                                </div>
                                <div class="form-group">
                                    <label for="pin">Pincode</labein>
                                    <input type="number" class="form-control" id="pin" placeholder="Enter the Pincode " name="pin" />
                                </div>
                            </div>
                        </div>
                        <p style="color:red;font-family: Times New Roman, Times, serif;">*The Password will automatically be 123. The company can change it by logging into their profiles</p>
                    </div>
                    <div class="card-action d-flex">
                        <button class="btn btn-success ms-auto" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Google Maps Plugin -->
    <script src="assets/js/plugin/gmaps/gmaps.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo2.js"></script>
  </body>
</html>
