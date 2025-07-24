<?php session_start();
include('includes/header.php');

if (!isset($_GET['tracking_no'])) {
    $_SESSION['message'] = "Nop tracking number provided!";
    header("Location:orders.php");
    exit();
}

$tracking_no = validate($_GET['tracking_no']);

$query = "SELECT O.*,c.name AS customer_name,c.email AS customer_email,c.phone AS customer_phone FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.tracking_no = '$tracking_no' LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    $_SESSION['message'] = "Order not found!";
    header("Location:orders.php");
    exit();
}

$order = mysqli_fetch_assoc($result);
$order_id = $order['id'];
$itemQuery = "SELECT oi.*,p.name AS product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = '$order_id'";

$itemResult = mysqli_query($conn, $itemQuery);

?>


<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <h3>Order details</h3>
        </div>
        <div class="mt-4 col-md-6">
            <a href="orders.php" class="btn btn-secondary">Back to orders</a>

        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Order Information</h5>
            </div>
            <div class="card-body">
                <p> <strong>Tracking No: </strong> <?= $order['tracking_no'] ?> </p>
                <p> <strong>Invoice No: </strong> <?= $order['invoice_no'] ?> </p>
                <p> <strong>Order Date: </strong> <?= $order['order_date'] ?> </p>
                <p> <strong>Order status: </strong> <?= $order['order_status'] ?> </p>
                <p> <strong>Payment Mode: </strong> <?= $order['payment_mode'] ?> </p>
                <p> <strong>Total Amount: </strong> <?= $order['total_amount'] ?> </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Customer Information</h5>
            </div>
            <div class="card-body">
                <p> <strong>Name: </strong> <?= $order['customer_name'] ?> </p>
                <p> <strong>Email: </strong> <?= $order['customer_email'] ?> </p>
                <p> <strong>Phone: </strong> <?= $order['customer_phone'] ?> </p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5>Ordered Products</h5>
    </div>
    <div class="card-body">
        <?php if ($itemResult && mysqli_num_rows($itemResult) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Price (Tk)</th>
                            <th>Quantity</th>
                            <th>Total (Tk)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $grandTotal = 0;
                        $i = 1;
                        while ($item = mysqli_fetch_assoc($itemResult)):
                            $lineTotal = $item['price'] * $item['quantity'];
                            $grandTotal += $lineTotal;
                        ?>

                            <tr>
                                <td> <?= $i++; ?> </td>
                                <td> <?= $item['product_name'] ?> </td>
                                <td> <?= number_format($item['price'], 2) ?> </td>
                                <td> <?= $item['quantity'] ?> </td>
                                <td> <?= number_format($lineTotal, 2) ?> </td>
                            </tr>

                        <?php endwhile; ?>
                        <tr class="table-secondary fw-bold">
                            <td colspan="4" class="text-end"> Total Amount </td>
                            <td> <?= number_format($grandTotal, 2) ?> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>NO products found for this order.</p>
        <?php endif; ?>
    </div>
</div>

</div>