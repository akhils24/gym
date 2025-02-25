<?php
include('header.php');

if(isset($_POST['assign']))
{
     $courierid=$_POST['cr'];
     $paymentid=$_POST['pay_id'];
     $Date = date ( "Y-m-d" );
     $maxdate=date('Y-m-d', strtotime($Date. ' + 10 days'));
     $payqry=mysqli_query($conn,"SELECT * FROM payment WHERE pay_id ='$paymentid'");
     $payrow=mysqli_fetch_assoc($payqry);
     $cartmqry=mysqli_query($conn,"SELECT * FROM cart_master WHERE cart_master_id = $payrow[cart_master_id]");
     $cartmrow=mysqli_fetch_assoc($cartmqry);
     $qry="INSERT INTO c_assign(courier_id,cart_master_id,cassign_date,cr_max_date,cr_status)VALUES('$courierid','$payrow[cart_master_id]',now(),'$maxdate','ASSIGNED')";
     mysqli_query($conn,$qry);
     mysqli_query($conn,"UPDATE payment SET cr_assign_status=1 WHERE pay_id='$paymentid'");
     mysqli_query($conn,"UPDATE cart_master SET cart_status='ASSIGNED' WHERE cart_master_id=$payrow[cart_master_id]");
}

?>

<div class="container">
    <div class="page-inner">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">COURIER ASSIGINMENT</h4>
                        <!-- <button class="btn btn-primary btn-round ms-auto" onclick="window.location.href='addcustomer.php'" data-bs-toggle="modal"> <i class="fa fa-plus"></i> Add Customer</button> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover" style="table-layout: fixed; width:150%">
                          <thead>
                            <tr>
                                <th style="width:110px">Sales-ID</th>
                                <th >Customer Name</th>
                                <th>Sales Date</th>
                                <th>Total Sales Amount </th>
                                <th style="width:10%">Items</th>
                                <th>Quantity</th>
                                <th colspan="2" style="text-align:center;">Courier-Assignment</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $py=mysqli_query($conn,"SELECT * FROM payment WHERE cr_assign_status=0");
                            if($py) {
                                while($pyrow =mysqli_fetch_assoc($py)) {
                                    $payment_date=$pyrow['pay_date'];
                                    $salesid=10000+$pyrow['pay_id'];

                                    $crt=mysqli_query($conn,"SELECT * FROM cart_master WHERE cart_master_id = '".$pyrow['cart_master_id']."'");
                                    $crtm=mysqli_fetch_assoc($crt);
                                    $tot_amt=$crtm['cart_tot_amt'];

                                    $cust=mysqli_query($conn,"SELECT * FROM customer WHERE customer_id='".$crtm['customer_id']."'");
                                    $custrw=mysqli_fetch_assoc($cust);

                                    echo "<tr>";
                                    echo "<td>" . $salesid . "</td>";
                                    echo "<td>" . $custrw['c_fname']."  ".$custrw['c_lname'] . "</td>";
                                    echo "<td>" . $payment_date. "</td>";
                                    echo "<td>" . $tot_amt . "</td>";
                                    // echo "<td>" . $row['pur_tot_amt'] . "</td>";
                                    
                                    echo "<td>"; 
                                    $crc=mysqli_query($conn,"SELECT * FROM cart_child WHERE cart_master_id='".$crtm['cart_master_id']."'");
                                    while($crc_row=mysqli_fetch_assoc($crc))
                                    {
                                    $it=mysqli_query($conn,"SELECT * FROM item WHERE item_id='".$crc_row['item_id']."'");
                                    $itrw=mysqli_fetch_assoc($it);
                                    echo $itrw['item_name']."<br>";
                                    }
                                    echo"</td>";

                                    echo "<td>"; 
                                    $crc=mysqli_query($conn,"SELECT * FROM cart_child WHERE cart_master_id='".$crtm['cart_master_id']."'");
                                    while($crc_row=mysqli_fetch_assoc($crc))
                                    {
                                    echo $crc_row['cart_qty']."<br>";
                                    }
                                    echo'</td>
                                    <form method="POST" action="">
                                    <td>
                                    <select class="form-select form-control" id="defaultSelect" name="cr" required >
                                        <option style=" color: gray;" value="" disabled selected hidden>Select Courier</option>';
                                        $ctqry=mysqli_query($conn,"SELECT * FROM courier WHERE co_status=1");
                                        if(mysqli_num_rows($ctqry)>0){
                                            while($ctrow=mysqli_fetch_assoc($ctqry)) {
                                                echo '<option value="'.$ctrow['courier_id'].'">'.$ctrow['co_name'].'</option>';
                                            }
                                        }
                                    echo '</select>
                                    <input type="hidden" name="pay_id" value="'. $pyrow['pay_id'] .'">
                                    </td>
                                    <td>
                                        <button type="submit" name="assign" class="btn btn-secondary"><span class="btn-label"><i class="fa fa-plus"></i></span>Assign</button>
                                    </td>
                                    </form>';
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