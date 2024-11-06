<?php
include('header.php');

if(isset($_POST['submit'])) {
    
    $vendor_id = $_POST['vendor'];
    $purdate = date("y-m-d");

    $items = $_POST['item'];
    $costs = $_POST['cost'];
    $qtys = $_POST['qty'];
    $tot_amt = 0;
    for ($i = 0; $i < count($items); $i++) 
    {
         $cost_price = $costs[$i];
         $quantity = $qtys[$i];
         $tot_amt += $cost_price * $quantity;
    }
    if($_SESSION['usertype'] == 'AD'){
        $userid='000';
    }else{
        $userid=$_SESSION['userid'];
    }
    mysqli_begin_transaction($conn);
    try{
        $purchase= "INSERT INTO purchase_master(staff_id,vendor_id,pur_date,pur_tot_amt)VALUES('$userid','$vendor_id','$purdate','$tot_amt')";
        if(mysqli_query($conn,$purchase)){
            $mast_id=mysqli_insert_id($conn);
            for($i=0; $i<count($items);$i++) {
                $item_id=$items[$i];
                $cost=$costs[$i];
                $qty=$qtys[$i];
                $tot_price=$cost*$qty;

                $itm=mysqli_query($conn,"SELECT * FROM item where item_id='$item_id'");
                $itm_row=mysqli_fetch_assoc($itm);
                $calc=$itm_row['item_profit']*$cost;
                $profit_percent=$calc/100;
                $sell_price=$cost+$profit_percent;

                $purchild="INSERT INTO purchase_child(pur_master_id,item_id,pur_qty,unit_price,tot_price,stock,sell_price)VALUES('$mast_id','$item_id','$qty','$cost','$tot_price','$qty','$sell_price')";
                mysqli_query($conn,$purchild);
                mysqli_commit($conn);
                echo "<script>alert('Purchase was Succesfull.Stock has been Updated !');window.location.href='index.php';</script>". mysqli_error($conn);
            }
        }
    } catch(Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Purchase Failed due to some issues. Please try again !');window.location.href='purchase.php';</script>". mysqli_error($conn);
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
                        <div class="card-title">NEW PURCHASE</div>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="card-body" style="width:auto;">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="defaultSelect">Vendor</label>
                                        <select class="form-select form-control" id="defaultSelect" name="vendor" >
                                            <option style=" color: gray;" value="" disabled selected hidden>Select Vendor</option>
                                            <?php
                                                $ctqry=mysqli_query($conn,"SELECT * FROM vendor WHERE v_status=1");
                                                if(mysqli_num_rows($ctqry)>0){
                                                    while($ctrow=mysqli_fetch_assoc($ctqry)) {
                                                        echo '<option value="'.$ctrow['vendor_id'].'">'.$ctrow['v_fname'].'</option>';
                                                    }
                                                }else{
                                                  echo '<option disabled selected hidden> No Vendors Available</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <a href="#" class="extra-fields-customer" id="regbtn" style="margin-top:40px;">Add New</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="width:auto;">
                            <div class="customer_records" data-template="true">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="defaultSelect">Item</label>
                                            <select name="item[]" id="defaultSelect" class="form-select form-control">
                                                <option value="" disabled selected hidden>Select item</option>
                                                <?php
                                                $sql = "SELECT item_id, item_name FROM item WHERE item_status=1";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) 
                                                {
                                                    while ($row = $result->fetch_assoc()) 
                                                    {
                                                            echo '<option value="' . $row["item_id"] . '">' . $row["item_name"] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="profit">Quantity</label>
                                            <input name="qty[]" class="form-control" id="profit" type="number" placeholder="Enter the Quantity of the Item">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="profit">Unit Cost</label>
                                            <input name="cost[]" class="form-control" id="profit" type="number" placeholder="Enter the Unit Cost of the Item">
                                        </div>
                                        <div class="form-group">
                                            <a href="#" class="remove-field extra-fields-customer" style="color: red; margin: top 40px;; display: none;">Remove</a> <!-- Initially hidden -->
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="customer_records_dynamic"></div>
                        </div>
                        <div class="card-action d-flex">
                            <button type="submit" class="btn btn-success ms-auto" name="submit">Submit</button>
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
    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>
    

<script type="text/javascript">

$('.extra-fields-customer').click(function(e) {
    e.preventDefault();
    
    // Clone the original customer_records block (marked with data-template) and append it to customer_records_dynamic
    let newFields = $('.customer_records[data-template="true"]').clone().removeAttr('data-template').appendTo('.customer_records_dynamic');
    
    newFields.addClass('single remove'); // Add single and remove classes for targeting
    newFields.find('.extra-fields-customer').hide(); // Hide "Add New" button in cloned fields
    newFields.find('.remove-field').show(); // Show "Remove" button in cloned fields
    
    // Clear values in the cloned row
    newFields.find('input').val(''); // Clears all input fields
    newFields.find('select').prop('selectedIndex', 0); // Resets all select dropdowns
});

$(document).on('click', '.remove-field', function(e) {
    e.preventDefault();
    $(this).closest('.remove').remove(); // Remove the entire cloned entry
});

</script>

  </body>
</html>

<style>
    .extra-fields-customer {
  display: inline-block;
  margin-top: 10px;
  text-decoration: none;
  color: #007bff;
  cursor: pointer;
}

.remove-field {
  display: inline-block;
  color: red;
  cursor: pointer;
  margin-top: 25px; /* Adjust to match the Add New button's alignment */
}

.extra-fields-customer:hover, .remove-field:hover {
  text-decoration: underline;
}

</style>