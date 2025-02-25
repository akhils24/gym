<?php
include('header.php');

if(isset($_POST['subcat_submit'])) {
    $cat=$_POST['cat'];
    $subcat=$_POST['subcat'];
    $subck=mysqli_query($conn,"SELECT * FROM subcategory WHERE subcat_name='$subcat'");
    if($subck->num_rows>0) {
        echo "Sub-Category already exists!";
    } else{
        $subcatqry=mysqli_query($conn,"INSERT INTO subcategory(cat_id,subcat_name) VALUES('$cat','$subcat')");
        if ($subcatqry) {
        echo "<script>alert('Sub-Category : ".$subcat." added successfully !');window.location.href='sub-category.php';</script>";
        } else {
        echo "<script>alert('Registration Failed due to some issues. Please try again !');window.location.href='sub-category.php';</script>". mysqli_error($conn);
        }
    }
    exit;
}

if(isset($_POST['deactivate'])) {
  $id=$_POST['id'];
  mysqli_begin_transaction($conn);
  try {
    $usr=mysqli_query($conn,"SELECT * FROM subcategory WHERE subcat_id ='$id'");
    $subcattbl=mysqli_fetch_assoc($usr);
    $qry=mysqli_query($conn,"UPDATE subcategory SET status=0 WHERE subcat_id='".$subcattbl['subcat_id']."'");  
    mysqli_commit($conn);
  } catch(Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Deactivation Failed due to some issues. Please try again !');window.location.href='subcategory.php';</script>";
  }
}

if(isset($_POST['activate'])) {
  $id=$_POST['id'];
  mysqli_begin_transaction($conn);
  try {
    $usr=mysqli_query($conn,"SELECT * FROM subcategory WHERE subcat_id ='$id'");
    $subcattbl=mysqli_fetch_assoc($usr);
    $qry=mysqli_query($conn,"UPDATE subcategory SET status=1 WHERE subcat_id='".$subcattbl['subcat_id']."'");  
    mysqli_commit($conn);
  } catch(Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Activation Failed due to some issues. Please try again !');window.location.href='subcategory.php';</script>";
  }
}
?>
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">ADD NEW SUB-CATEGORY</div>
                    </div>
                    <form method="POST" action="">
                        <div class="card-body" style="width:auto;">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="subcat">Sub-category Name</label>
                                        <input type="text" class="form-control" id="subcat" placeholder="Enter the Sub-Category" name="subcat" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="defaultSelect">Category</label>
                                        <select class="form-select form-control" id="defaultSelect" name="cat" >
                                            <option style=" color: gray;" value="" disabled selected hidden>Select Category</option>
                                            <?php
                                                $ctqry=mysqli_query($conn,"SELECT * FROM category WHERE status=1");
                                                if(mysqli_num_rows($ctqry)>0){
                                                    while($ctrow=mysqli_fetch_assoc($ctqry)) {
                                                        echo '<option value="'.$ctrow['cat_id'].'">'.$ctrow['cat_name'].'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action d-flex">
                            <button type="submit" class="btn btn-success ms-auto" name="subcat_submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">SUB-CATEGORY DETAILS</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Sub-category-ID</th>
                                <th>Sub-category Name</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $stf=mysqli_query($conn,"SELECT * FROM subcategory");
                            if($stf) {
                                while($row =mysqli_fetch_assoc($stf)) {
                                    $cat_tbl=mysqli_query($conn,"SELECT * FROM  category WHERE cat_id='". $row['cat_id'] ."'");
                                    $cat=mysqli_fetch_assoc($cat_tbl);
                                echo "<tr>";
                                echo "<td>" . $row['subcat_id'] . "</td>";
                                echo "<td>" . $row['subcat_name'] . "</td>";
                                echo "<td>" . $cat['cat_name'] . "</td>";
                                if($row['status']==1)
                                    echo "<td>Active</td>";
                                else
                                    echo "<td>Inactive</td>";
                                echo '<td>
                                    <form method="POST" action="" >
                                    <input type="hidden"  name="id" value="'. $row['subcat_id'] .'">';
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

