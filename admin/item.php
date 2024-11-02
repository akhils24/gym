<?php
include('header.php');

if(isset($_POST['item_submit'])) {
  $subcat = $_POST['subcat'];
  $item_name = $_POST['name'];
  $description = $_POST['desc'];
  $price = $_POST['price'];
  $profit = $_POST['profit'];
  $image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); // Convert the image to binary data
  $image_name = $_FILES['image']['name'];

  $itmck=mysqli_query($conn,"SELECT * FROM item WHERE item_name='$subcat' AND subcat_id='$subcat'");
  if($itmck->num_rows>0) {
      echo "Item under this Sub-category already exists!";
  } else{
    mysqli_begin_transaction($conn);
    try{
      $itmqry=mysqli_query($conn,"INSERT INTO item(subcat_id,item_name,item_desc,item_image,image_name,item_price,item_profit)VALUES('$subcat','$item_name','$description','$image','$image_name','$price','$profit')");
      mysqli_commit($conn);
      echo "<script>alert('Item : ".$item_name." added successfully ');window.location.href='item.php';</script>";
    } catch(Exception $e) {
      mysqli_rollback($conn);
      echo "<script>alert(' Failed due to some issues. Please try again !');window.location.href='item.php';</script>". mysqli_error($conn);
    }
  }
}

if(isset($_POST['deactivate'])) {
  $id=$_POST['id'];
  mysqli_begin_transaction($conn);
  try {
    $usr=mysqli_query($conn,"SELECT * FROM item WHERE item_id ='$id'");
    $itemtbl=mysqli_fetch_assoc($usr);
    $qry=mysqli_query($conn,"UPDATE item SET item_status=0 WHERE item_id='".$itemtbl['item_id']."'");  
    mysqli_commit($conn);
  } catch(Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Deactivation Failed due to some issues. Please try again !');window.location.href='item.php';</script>";
  }
}

if(isset($_POST['activate'])) {
  $id=$_POST['id'];
  mysqli_begin_transaction($conn);
  try {
    $usr=mysqli_query($conn,"SELECT * FROM item WHERE item_id ='$id'");
    $itemtbl=mysqli_fetch_assoc($usr);
    $qry=mysqli_query($conn,"UPDATE item SET item_status=1 WHERE item_id='".$itemtbl['item_id']."'");  
    mysqli_commit($conn);
  } catch(Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Activation Failed due to some issues. Please try again !');window.location.href='item.php';</script>";
  }
}
?>
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">ADD NEW ITEM</div>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="card-body" style="width:auto;">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Item Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter the Item Name" name="name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="defaultSelect">Sub-Category</label>
                                        <select class="form-select form-control" id="defaultSelect" name="subcat" >
                                            <option style=" color: gray;" value="" disabled selected hidden>Select Sub-Category</option>
                                            <?php
                                                $ctqry=mysqli_query($conn,"SELECT * FROM subcategory WHERE status=1");
                                                if(mysqli_num_rows($ctqry)>0){
                                                    while($ctrow=mysqli_fetch_assoc($ctqry)) {
                                                        echo '<option value="'.$ctrow['subcat_id'].'">'.$ctrow['subcat_name'].'</option>';
                                                    }
                                                }else{
                                                  echo '<option disabled selected hidden> No Sub-Category Available</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                  <div class="form-group">
                                    <label for="exampleFormControlFile1">Item Image</label>
                                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image" />
                                  </div>
                                  <div class="form-group">
                                    <label for="description">Item Description</label>
                                    <textarea name="desc"  class="form-control" aria-label="With textarea" id="description" placeholder="Enter the Item Description "></textarea>
                                  </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                  <div class="form-group">
                                    <label for="price">Item Price</label>
                                    <input type="number" class="form-control" id="price" placeholder="Enter the price of the Item " name="price" />
                                  </div>
                                  <div class="form-group">
                                    <label for="profit">Profit Percentage</label>
                                    <input type="text" class="form-control" id="profit" placeholder="Enter the profit percentage of the Item" name="profit" />
                                  </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-action d-flex">
                            <button type="submit" class="btn btn-success ms-auto" name="item_submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">ITEM DETAILS</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Item-ID</th>
                                <th>Item Name</th>
                                <th>Sub-Category</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>profit Percentage</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $itm=mysqli_query($conn,"SELECT * FROM item");
                            if($itm) {
                                while($row =mysqli_fetch_assoc($itm)) {
                                    $subcat_tbl=mysqli_query($conn,"SELECT * FROM  subcategory WHERE subcat_id='". $row['subcat_id'] ."'");
                                    $subcat=mysqli_fetch_assoc($subcat_tbl);
                                echo "<tr>";
                                echo "<td>" . $row['item_id'] . "</td>";
                                echo "<td>" . $row['item_name'] . "</td>";
                                echo "<td>" . $subcat['subcat_name'] . "</td>";
                                echo "<td>" . $row['item_desc'] . "</td>";
                                echo '<td><img class="imagecheck-image" style="opacity:1;" src="data:image/jpeg;base64,' . base64_encode($row['item_image']) . '" alt="' . $row['image_name'] . '" /></td>';
                                echo "<td>" . $row['item_price'] . "</td>";
                                echo "<td>" . $row['item_profit'] . "</td>";
                                if($row['item_status']==1)
                                    echo "<td>Active</td>";
                                else
                                    echo "<td>Inactive</td>";
                                echo '<td>
                                    <form method="POST" action="" >
                                    <input type="hidden"  name="id" value="'. $row['item_id'] .'">';
                                    if($row['item_status']==1) {
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

