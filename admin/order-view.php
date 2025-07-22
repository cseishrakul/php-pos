<?php session_start();
include('includes/header.php');

if(!isset($_GET['tracking_no'])){
    $_SESSION['message'] = "Nop tracking number provided!";
    header("Location:orders.php");
    exit();
}

$tracking_no = validate($_GET['tracking_no']);

$query = "SELECT O.*,c.name AS customer_name,c.email AS customer_email,c.phone AS customer_phone FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.tracking_no = '$tracking_no' LIMIT 1";

$result = mysqli_query($conn,$query);

if(!$result || mysqli_num_rows($result) == 0){
    $_SESSION['message'] = "Order not found!";
    header("Location:orders.php");
    exit();
}

$order = mysqli_fetch_assoc($result);
$order_id = $order['id'];
$itemQuery = "SELECT oi.*,p.name AS product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = '$order_id'";

$itemResult = mysqli_query($conn,$itemQuery);

?>


<div class="container py-4">
    <h3>Order details</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Order Information</h5>
                </div>
                <div class="card-body">
                    <p> <strong>Tracking No: </strong>  <?= $order['tracking_no'] ?> </p>
                    <p> <strong>Invoice No: </strong>  <?= $order['invoice_no'] ?> </p>
                    <p> <strong>Order Date: </strong>  <?= $order['order_date'] ?> </p>
                    <p> <strong>Order status: </strong>  <?= $order['order_status'] ?> </p>
                    <p> <strong>Payment Mode: </strong>  <?= $order['payment_mode'] ?> </p>
                    <p> <strong>Total Amount: </strong>  <?= $order['total_amount'] ?> </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Customer Information</h5>
                </div>
                <div class="card-body">
                    <p> <strong>Name: </strong>  <?= $order['customer_name'] ?> </p>
                    <p> <strong>Email: </strong>  <?= $order['customer_email'] ?> </p>
                    <p> <strong>Phone: </strong>  <?= $order['customer_phone'] ?> </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Ordered Products</h5>
        </div>
        <div class="card-body"></div>
    </div>

</div>