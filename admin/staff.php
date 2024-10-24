<?php
include('header.php');
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
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header">
                      <div class="d-flex align-items-center">
                          <h4 class="card-title">STAFF DETAILS</h4>
                          <button class="btn btn-primary btn-round ms-auto" onclick="window.location.href='addstaff.php'" data-bs-toggle="modal"> <i class="fa fa-plus"></i> Add Staff </button>
                      </div>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="add-row" class="display table table-striped table-hover" style="table-layout: fixed; width:120%">
                            <thead>
                              <tr>
                                  <th>Staff-ID</th>
                                  <th style="width:auto">Username</th>
                                  <th>Name</th>
                                  <th>Phone</th>
                                  <th>Gender</th>
                                  <th>DOB</th>
                                  <th>Place</th>
                                  <th>District</th>
                                  <th>Status</th>
                                  <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $stf=mysqli_query($conn,"SELECT * FROM staff");
                              if($stf) {
                                while($row =mysqli_fetch_assoc($stf)) {
                                  echo "<tr>";
                                  echo "<td>" . $row['staff_id'] . "</td>";
                                  echo "<td>" . $row['username'] . "</td>";
                                  echo "<td>" . $row['s_fname'] ." ".$row['s_lname']. "</td>";
                                  echo "<td>" . $row['s_phno'] . "</td>";
                                  echo "<td>" . $row['s_gender'] . "</td>";
                                  echo "<td>" . $row['s_dob'] . "</td>";
                                  echo "<td>" . $row['s_place'] . "</td>";
                                  echo "<td>" . $row['s_dist'] . "</td>";
                                  if($row['s_status']==1)
                                    echo "<td>Active</td>";
                                  else
                                    echo "<td>Inactive<td>";
                                  echo '<td>
                                        <div class="form-button-action">
                                            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg"> <i class="fa fa-edit"></i> </button>
                                            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" > <i class="fa fa-times"></i> </button>
                                        </div>
                                        </td>';
                                  echo "</tr>";
                                }
                              }?>
                              </tr>
                            </tbody>
                          </table>
                        </div>
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
    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <script>
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
          $("#add-row")
            .dataTable()
            .fnAddData([
              $("#addName").val(),
              $("#addPosition").val(),
              $("#addOffice").val(),
              action,
            ]);
          $("#addRowModal").modal("hide");
        });
      });
    </script>
  </body>
</html>

