<?php
include('header.php');
?>

<div class="container">
    <div class="page-inner">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">PURCHASE REPORT</h4>
                        <!-- <button class="btn btn-primary btn-round ms-auto" onclick="window.location.href='addcustomer.php'" data-bs-toggle="modal"> <i class="fa fa-plus"></i> Add Customer</button> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover" style="table-layout: fixed; width:150%">
                          <thead>
                            <tr>
                                <th style="width:110px">Purchase-ID</th>
                                <th >Vendor Name</th>
                                <th>Staff Name</th>
                                <th>Purchase Date</th>
                                <th>Total Amount </th>
                                <th style="width:10%">Items</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>In Stock</th>
                                <th style="width:100px">Selling Price</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $prq=mysqli_query($conn,"SELECT * FROM purchase_master");
                            if($prq) {
                              while($row =mysqli_fetch_assoc($prq)) {
                                if($row['staff_id']==000)
                                    $stfname='ADMIN';
                                else{
                                    $stf=mysqli_query($conn,"SELECT * FROM staff WHERE staff_id='".$row['staff_id']."'");
                                    $stf_tbl=mysqli_fetch_assoc($stf);
                                    $stfname=$stf_tbl['s_fname'];
                                }

                                $vnd=mysqli_query($conn,"SELECT * FROM vendor WHERE vendor_id='".$row['vendor_id']."'");
                                $vnd_tbl=mysqli_fetch_assoc($vnd);
                                $vndname=$vnd_tbl['v_fname'];

                                echo "<tr>";
                                echo "<td>" . $row['pur_master_id'] . "</td>";
                                echo "<td>" . $vndname. "</td>";
                                echo "<td>" . $stfname. "</td>";
                                echo "<td>" . $row['pur_date'] . "</td>";
                                echo "<td>" . $row['pur_tot_amt'] . "</td>";
                                
                                echo "<td>"; 
                                $prc=mysqli_query($conn,"SELECT * FROM purchase_child WHERE pur_master_id='".$row['pur_master_id']."'");
                                while($prc_row=mysqli_fetch_assoc($prc))
                                {
                                  $it=mysqli_query($conn,"SELECT * FROM item WHERE item_id='".$prc_row['item_id']."'");
                                  $itrw=mysqli_fetch_assoc($it);
                                  echo $itrw['item_name']."<br>";
                                }
                                echo"</td>";

                                echo "<td>"; 
                                $prc=mysqli_query($conn,"SELECT * FROM purchase_child WHERE pur_master_id='".$row['pur_master_id']."'");
                                while($prch_row=mysqli_fetch_assoc($prc))
                                {
                                  echo $prch_row['pur_qty']."<br>";
                                }
                                echo"</td>";

                                echo "<td>"; 
                                $prc=mysqli_query($conn,"SELECT * FROM purchase_child WHERE pur_master_id='".$row['pur_master_id']."'");
                                while($prch_row=mysqli_fetch_assoc($prc))
                                {
                                  echo $prch_row['unit_price']."<br>";
                                }
                                echo"</td>";

                                echo "<td>"; 
                                $prc=mysqli_query($conn,"SELECT * FROM purchase_child WHERE pur_master_id='".$row['pur_master_id']."'");
                                while($prch_row=mysqli_fetch_assoc($prc))
                                {
                                  echo $prch_row['tot_price']."<br>";
                                }
                                echo"</td>";

                                echo "<td>"; 
                                $prc=mysqli_query($conn,"SELECT * FROM purchase_child WHERE pur_master_id='".$row['pur_master_id']."'");
                                while($prch_row=mysqli_fetch_assoc($prc))
                                {
                                  echo $prch_row['stock']."<br>";
                                }
                                echo"</td>";

                                echo "<td>"; 
                                $prc=mysqli_query($conn,"SELECT * FROM purchase_child WHERE pur_master_id='".$row['pur_master_id']."'");
                                while($prch_row=mysqli_fetch_assoc($prc))
                                {
                                  echo $prch_row['sell_price']."<br>";
                                }
                                echo"</td>";
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