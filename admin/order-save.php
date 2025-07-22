<?php

include('../config/functions.php');

if (!isset($_SESSION['order_customer_id']) || !isset($_SESSION['productItems'])) {
    $_SESSION['message'] = "No order data found!";
    header('Location: order-create.php');
    exit();
}

$customer_id = $_SESSION['order_customer_id'];
$payment_mode = $_SESSION['payment_mode'] ?? 'Cash';
$productItems = $_SESSION['productItems'];
$total_amount = 0;

foreach ($productItems as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

$invoice_no = 'INV-' . strtoupper(uniqid());

$tracking_no = 'TRK-' . strtoupper(uniqid());
$order_date = date('Y-m-d');
$order_status = 'confirmed';
$order_by_id = $_SESSION['loggiedInUser']['user_id'] ?? 1;

$insertOrderQuery = "INSERT INTO orders (customer_id,tracking_no,invoice_no,total_amount,order_date,order_status,payment_mode,order_placed_by_id) VALUES ('$customer_id','$tracking_no','$invoice_no','$total_amount','$order_date','$order_status','$payment_mode','$order_by_id')";

$runOrder = mysqli_query($conn, $insertOrderQuery);
if ($runOrder) {
    $order_id = mysqli_insert_id($conn);

    foreach ($productItems as $item) {
        $prod_id = $item['product_id'];
        $price = $item['price'];
        $qty = $item['quantity'];

        $insertItem = "INSERT INTO order_items (order_id,product_id,price,quantity) VALUES ('$order_id','$prod_id','$price','$qty')";

        mysqli_query($conn, $insertItem);

        mysqli_query($conn, "UPDATE products SET quantity = quantity - $qty WHERE id = '$prod_id'");
    }

    unset($_SESSION['productItems']);
    unset($_SESSION['productItemIds']);
    unset($_SESSION['order_customer_id']);
    unset($_SESSION['payment_mode']);
    unset($_SESSION['customer_phone']);

    $_SESSION['message'] = "Order Placed Successfully!";
    header('Location:orders.php');
    exit();
} else {
    $_SESSION['message'] = "Failed to place order";
}
