<?php
include('header.php');
if(isset($_POST['submit'])) {
  $firstName = $_POST['fname'];
  $lastName = $_POST['lname'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $dob = $_POST['dob'];
  $phoneNumber = $_POST['phno'];
  $district = $_POST['dist'];
  $place = $_POST['place'];
  $passwordleft = $_POST['passd'];

  $lgn=mysqli_query($conn,"SELECT * FROM login WHERE username='$email'");
  if(mysqli_num_rows($lgn)) {
    echo "<script>alert('Username has already been used !');window.location.href='addstaff.php';</script>";
  } else {
    mysqli_begin_transaction($conn);
    try {
        $lgqry= "INSERT INTO login(username,password,user_type)VALUES('$email','$passwordleft','ST')";
        mysqli_query($conn,$lgqry);
        $stfqry= "INSERT INTO staff(username,s_fname,s_lname,s_phno,s_place,s_dist,s_gender,s_dob)VALUES('$email','$firstName','$lastName','$phoneNumber','$place','$district','$gender','$dob')";
        mysqli_query($conn,$stfqry);
        mysqli_commit($conn);
        echo "<script>alert('Details of ".$firstName." have registered successfully!');window.location.href='staff.php';</script>";
    } catch(Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Registration Failed due to some issues. Please try again !');window.location.href='staff.php';</script>";
    }
  }
}
?>

<div class="main-panel">
  <div class="main-header">
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
      <div class="container-fluid">
        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex" >
          <div class="input-group">
            <input type="text" placeholder="Search ..." class="form-control"/>
            <div class="input-group-prepend">
              <button type="submit" class="btn btn-search pe-1"> <i class="fa fa-search search-icon"></i> </button>
            </div>
          </div>
        </nav>
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
          <li class="nav-item topbar-user dropdown hidden-caret">
            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false" >
              <div class="avatar-sm">
                <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
              </div>
              <span class="profile-username">
                <span class="op-7">Hi,</span>
                <?php if($_SESSION['usertype'] == 'AD'):?>
                 <span class="fw-bold">Admin</span>
                <?php elseif($_SESSION['usertype'] == 'ST') :?>
                  <span class="fw-bold">Staff</span>
                  <?php endif;?>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
              <div class="dropdown-user-scroll scrollbar-outer">
                <li>
                  <div class="user-box">
                    <div class="avatar-lg">
                      <img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded" />
                    </div>
                    <div class="u-text">
                      <?php if($_SESSION['usertype'] == 'AD'):?>
                      <h4>ADMIN</h4>
                      <p class="text-muted">admin@example.com</p>
                      <?php elseif($_SESSION['usertype'] == 'ST') :?>
                      <h4>STAFF</h4>
                      <p class="text-muted">staff@example.com</p>
                      <a href="profile.html" class="btn btn-xs btn-secondary btn-sm" >View Profile</a>
                      <?php endif;?>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php">Logout</a>
                </li>
              </div>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </div>

  <div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">ADD NEW STAFF</div>
                    </div>
                    <form method="POST" action="">
                        <div class="card-body" style="width:auto;">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="email2">Email Address</label>
                                        <input type="email" class="form-control" id="email2" placeholder="Enter Email" name="email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password" name="passd"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Gender</label><br />
                                        <div class="d-flex">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="Male" />
                                                <label class="form-check-label" for="flexRadioDefault1" > Male </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="Female"/>
                                                <label class="form-check-label" for="flexRadioDefault2" > Female </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault3" value="Others"/>
                                                <label class="form-check-label" for="flexRadioDefault3" > Others </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" class="form-control" id="fname" placeholder="Enter your First Name" name="fname" />
                                    </div>
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" class="form-control" id="lname" placeholder="Enter your Last Name" name="lname"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" placeholder="Enter DOB" name="dob" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="phno">Phone Number</label>
                                        <input type="phone" class="form-control" id="phno" placeholder="Enter your Phone Number " name="phno" />
                                    </div>
                                    <div class="form-group">
                                        <label for="place">place</label>
                                        <input type="text" class="form-control" id="place" placeholder="Enter the Place" name="place" />
                                    </div>
                                    <div class="form-group">
                                        <label for="dist">District</label>
                                        <input type="text" class="form-control" id="dist" placeholder="Enter the District" name="dist" />
                                    </div>
                                </div>
                            </div>
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
