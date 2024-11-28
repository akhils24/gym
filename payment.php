<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Payment</title>
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favi.png"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ced1d3;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .cart-summary, .payment-section {
            padding: 20px;
        }
        .cart-summary {
            flex: 1 1 50%;
            border-right: 1px solid #ddd;
        }
        .payment-section {
            flex: 1 1 50%;
        }
        h2 {
            margin-top: 0;
        }
        .product {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .product img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
        }
        .product-details {
            flex: 2;
        }
        .product-name {
            font-size: 16px;
            font-weight: bold;
        }
        .product-price {
            margin-top: 10px;
            color: #28a745;
        }
        .product-quantity{
            margin-right: 100px;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: calc(100% - 20px);
            padding: 8px 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group select {
            width: calc(100% - 20px);
            padding: 8px 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-pay,.btn-not-pay {
            display: block;
            width: 100%;
            padding: 10px 0;
            font-size: 18px;
            color: #fff;
            background-color: #127def;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-pay:hover {
            background-color: #023e7d;
        }
    </style>

</head>
<body>

<?php
// include('crt-header.php');

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "gym";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if ($conn->connect_error) {
    die("connection Failed: " . $conn->connect_error);
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$userid = $_SESSION['userid'];
$cart_master_id=$_SESSION['cartmid'];
$cart=mysqli_query($conn,"SELECT * FROM cart_master WHERE cart_master_id='$cart_master_id'");
$cartm=mysqli_fetch_assoc($cart);

if(isset($_POST['payment'])) {
    $card=$_POST['card'];
    $cvv=$_POST['cvv'];
    $qry=mysqli_query($conn,"SELECT * FROM card WHERE card_id = $card");
    $sql=mysqli_fetch_assoc($qry);
    if($cvv===$sql['cvv']){
        mysqli_begin_transaction($conn);
        try{
            $sql1=mysqli_query($conn,"SELECT * FROM cart_child WHERE cart_master_id = $cart_master_id");
            while ($row = $sql1->fetch_assoc()){
                $qty=$row['cart_qty'];
                $pr=mysqli_query($conn,"SELECT * FROM purchase_child  WHERE item_id=$row[item_id]  AND pur_child_id= $row[purch_id] OR sell_price= $row[item_rate]  AND stock>0 ORDER BY Pur_child_id ASC limit 1 ");
                $prrow=mysqli_fetch_assoc($pr);
                $purqry=mysqli_query($conn,"UPDATE purchase_child SET stock=stock-$qty WHERE pur_child_id=$prrow[pur_child_id]");
            }
            $cartm_qry=mysqli_query($conn,"UPDATE cart_master SET cart_status='PAID' WHERE cart_master_id = $cart_master_id");
            $pay=mysqli_query($conn,"INSERT INTO payment(Cart_master_id,card_id,pay_date) VALUES ('$cart_master_id','$card',now())");
            mysqli_commit($conn);
            echo "<script>
                    swal({
                        title: 'Payment Successful!',
                        text: 'Your order has been placed successfully.',
                        icon: 'success',
                        buttons: {
                            confirm: {
                                text: 'Ok',
                                className: 'btn btn-success'
                            }
                        }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                  </script>";
        }catch(Exception $e){
            mysqli_rollback($conn);
            echo "<script>
                    swal({
                        title: 'Payment Failed!',
                        text: 'An error occurred. Please try again.',
                        icon: 'error',
                        buttons: {
                            confirm: {
                                text: 'Retry',
                                className: 'btn btn-danger'
                            }
                        }
                    }).then(() => {
                        window.location.href = 'cart.php';
                    });
                  </script>";
        } 
    }else{
        echo "<script>
                swal({
                    title: 'Invalid CVV!',
                    text: 'You have entered the wrong CVV.',
                    icon: 'warning',
                    buttons: {
                        confirm: {
                            text: 'Retry',
                            className: 'btn btn-warning'
                        }
                    }
                });
              </script>";
    }
}
?>

<!-- <script>
    swal("Library Check", "SweetAlert is working!", "info");
</script> -->
    <div class="container">  
        <!-- Cart Summary Section -->
        <div class="cart-summary">
            <h2>Cart Summary</h2>
            <?php
                $crtch = mysqli_query($conn, "SELECT * FROM cart_child WHERE cart_master_id=$cartm[cart_master_id]");
                while ($row = $crtch->fetch_assoc()):
                    $purqry = "SELECT * FROM purchase_child WHERE item_id = $row[item_id] AND stock > 0 ORDER BY Pur_child_id ASC LIMIT 1";
                    $purcon = mysqli_query($conn, $purqry);
                    $purresult = $purcon->fetch_assoc();
                    $itm = mysqli_query($conn, "SELECT * FROM item WHERE item_id=$row[item_id]");
                    $result = $itm->fetch_assoc();
            ?>
            <div class="product">
                <?php echo '<img class="d-block ui-w-40 ui-bordered mr-4" style="height:60px; width:60px;" src="data:image/jpeg;base64,' . base64_encode($result['item_image']) . '" alt="' . $result['image_name'] . '">'; ?>
                <div class="product-details">
                    <div class="product-name"><?php echo $result['item_name']; ?></div>
                    <div class="product-price">$ <?php echo $purresult['sell_price']; ?></div>
                </div>
                <div class="product-quantity">Qty: <?php echo $row['cart_qty']; ?></div>
                <div class="product-total">$ <?php echo $row['item_total']; ?></div>
            </div>
            <?php
            endwhile;
            ?>
            <div class="total">Grand Total: $ <?php echo "$cartm[cart_tot_amt]"; ?></div>
        </div>
    </div>
    <div class="container">
        <!-- Payment Section -->
        <div class="payment-section">
            <h2>Payment</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="card">Card Type</label>
                    <?php
                        $crd=mysqli_query($conn,"SELECT * FROM card WHERE customer_id = '$userid'");
                        if(mysqli_num_rows($crd)>0): ?>
                            <select id="card" name="card">
                                <option value=" " disabled selected hidden >Select the Card for Payment</option>
                                <?php while($cards=mysqli_fetch_assoc($crd)): ?>
                                    <option value="<?php echo $cards['card_id'];?>"><?php echo $cards['card_no'];?></option>
                                <?php endwhile;?>
                            </select>
                        <?php else:?>
                            <select id="card" name="card">
                                <option value="" disabled selected  hidden>Add a new card in profile to make payment </option>
                            </select>
                        <?php endif;?>
                </div>
                <!-- <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" name="card_number" placeholder="1234 5678 9101 1121" required>
                </div> -->
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="Enter the CVV" required>
                </div>
                <?php if(mysqli_num_rows($crd)>0): ?>
                    <button name="payment" type="submit" class="btn-pay">Pay $ <?php echo "$cartm[cart_tot_amt]"; ?></button>
                <?php else :?>
                    <button  type="submit" class="btn-not-pay">Pay $ <?php echo "$cartm[cart_tot_amt]"; ?></button>
                <?php endif;?>
            </form>
        </div>
    </div>
    <!-- <button type="button" class="btn btn-success" id="alert_demo_4">Show me</button> -->
</body>
</html>
