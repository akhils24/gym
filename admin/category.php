<?php
include('header.php');

if(isset($_POST['deactivate'])) {
  $id=$_POST['id'];
  mysqli_begin_transaction($conn);
  try {
    $usr=mysqli_query($conn,"SELECT * FROM category WHERE cat_id ='$id'");
    $courtbl=mysqli_fetch_assoc($usr);
    $qry=mysqli_query($conn,"UPDATE category SET status=0 WHERE cat_id='".$courtbl['cat_id']."'");  
    mysqli_commit($conn);
  } catch(Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Deactivation Failed due to some issues. Please try again !');window.location.href='category.php';</script>";
  }
}

if(isset($_POST['activate'])) {
  $id=$_POST['id'];
  mysqli_begin_transaction($conn);
  try {
    $usr=mysqli_query($conn,"SELECT * FROM category WHERE cat_id ='$id'");
    $courtbl=mysqli_fetch_assoc($usr);
    $qry=mysqli_query($conn,"UPDATE category SET status=1 WHERE cat_id='".$courtbl['cat_id']."'");  
    mysqli_commit($conn);
  } catch(Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Activation Failed due to some issues. Please try again !');window.location.href='category.php';</script>";
  }
}
?>
<div class="container">
    <div class="page-inner">
      <div style="margin:auto;" class="col-md-10">
          <div class="card">
              <div class="card-header">
                  <div class="d-flex align-items-center">
                      <h4 class="card-title">CATEGORY DETAILS</h4>
                      <!-- <button type="button" class="btn btn-warning" id="alert_demo_5" > Show me </button> -->
                      <button type="button" class="btn btn-primary btn-round ms-auto" id="alert_demo_5"  data-bs-toggle="modal"> <i class="fa fa-plus"></i> Add category </button>
                  </div>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                      <table id="add-row" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                              <th>category-ID</th>
                              <th>Category Name</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $stf=mysqli_query($conn,"SELECT * FROM category");
                          if($stf) {
                            while($row =mysqli_fetch_assoc($stf)) {
                              echo "<tr>";
                              echo "<td>" . $row['cat_id'] . "</td>";
                              echo "<td>" . $row['cat_name'] . "</td>";
                              if($row['status']==1)
                                echo "<td>Active</td>";
                              else
                                echo "<td>Inactive</td>";
                              echo '<td>
                                <form method="POST" action="" >
                                  <input type="hidden"  name="id" value="'. $row['cat_id'] .'">';
                                  if($row['status']==1) {
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
     <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
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

      var SweetAlert2Demo = (function () {
        var initDemos = function (){
          $("#alert_demo_5").click(function (e) {
            swal({
              title: "Add New Category",
              content: {
                element: "input",
                attributes: {
                  placeholder: "Enter the new category",
                  type: "text",
                  id: "input-field",
                  className: "form-control",
                },
              },
              buttons: {
                cancel: {
                  visible: true,
                  className: "btn btn-danger",
                },
                confirm: {
                  className: "btn btn-success",
                },
              },
            }).then(function (value) {
              if (value) {
                // Perform AJAX call to send input to PHP
                $.ajax({
                  url: "addcat.php", // PHP file to handle the request
                  method: "POST",
                  data: { input: value },
                  success: function (response) {
                    swal("", "Category : " + value + response, "success").then(function() {
                        location.reload();
                        });
                  },
                  error: function () {
                    swal("", "There was an error saving your input.", "error");
                  }
                });
              } else {
                swal("", "No Category was Added.", "info");
              }
            });
          });
        };
        return {
            init: function () {
              initDemos();
            },
          };
        })();
      jQuery(document).ready(function () {
        SweetAlert2Demo.init();
      });
    </script>
  </body>
</html>

