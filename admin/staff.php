<?php
include('header.php');
if(isset($_POST['deactivate'])) {
  $id=$_POST['id'];
  mysqli_begin_transaction($conn);
  try {
    $usr=mysqli_query($conn,"SELECT * FROM staff WHERE staff_id ='$id'");
    $stafftbl=mysqli_fetch_assoc($usr);
    $qry=mysqli_query($conn,"UPDATE login SET login_status=0 WHERE username='".$stafftbl['username']."'");
    $qry=mysqli_query($conn,"UPDATE staff SET s_status=0 WHERE staff_id='".$stafftbl['staff_id']."'");  
    mysqli_commit($conn);
  } catch(Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Deactivation Failed due to some issues. Please try again !');window.location.href='staff.php';</script>";
  }
}
if(isset($_POST['activate'])) {
  $id=$_POST['id'];
  mysqli_begin_transaction($conn);
  try {
    $usr=mysqli_query($conn,"SELECT * FROM staff WHERE staff_id ='$id'");
    $stafftbl=mysqli_fetch_assoc($usr);
    $qry=mysqli_query($conn,"UPDATE login SET login_status=1 WHERE username='".$stafftbl['username']."'");
    $qry=mysqli_query($conn,"UPDATE staff SET s_status=1 WHERE staff_id='".$stafftbl['staff_id']."'");  
    mysqli_commit($conn);
  } catch(Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Activation Failed due to some issues. Please try again !');window.location.href='staff.php';</script>";
  }
}
?>
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
                        <table id="add-row" class="display table table-striped table-hover" style="table-layout: fixed; width:130%">
                          <thead>
                            <tr>
                                <th>Staff-ID</th>
                                <th style="width:10%">Username</th>
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
                                  echo "<td>Inactive</td>";
                                echo '<td>
                                  <form method="POST" action="" >
                                    <input type="hidden"  name="id" value="'. $row['staff_id'] .'">';
                                    if($row['s_status']==1) {
                                      echo '<div class="form-button-action">                
                                      <button type="submit" name="edit" data-bs-toggle="tooltip" title="Edit" class="btn btn-link btn-primary btn-lg"> <i class="fa fa-edit"></i> </button>
                                      <button type="submit" name="deactivate"  title="Deactivate" class="btn btn-link btn-danger" > <i class="fa fa-times"></i> </button>
                                      </div>';
                                    }else{
                                      echo '<div class="form-button-action">                
                                      <button type="submit" name="edit" data-bs-toggle="tooltip" title="Edit" class="btn btn-link btn-primary btn-lg"> <i class="fa fa-edit"></i> </button>
                                      <button type="submit" name="activate" data-bs-toggle="tooltip" title="Activate" class="btn btn-link btn-success" > <i class="fa fa-plus"></i> </button>
                                      </div>';
                                    }
                                  echo '</form>  
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

