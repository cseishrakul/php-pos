<?php
session_start();
include('includes/header.php');

$query = "SELECT o.id, o.tracking_no, o.order_date, o.order_status,o.payment_mode,c.name AS customer_name,c.phone AS customer_phone FROM orders o JOIN customers c ON o.customer_id = c.id ORDER BY o.order_date DESC";

$result = mysqli_query($conn, $query);
?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Orders List</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Customers / User</li>
        <a href="customer-create.php" class="btn btn-primary ms-auto">Create Customer +</a>
    </ol>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"> <?= $_SESSION['message']; ?> </div>
    <?php endif ?>


    <div class="card shadow-sm">
        <div class="card-body">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tracking No</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($order = mysqli_fetch_assoc($result)): ?>

                                <tr>
                                    <td> <?= $i++; ?> </td>
                                    <td> <?= $order['tracking_no'] ?> </td>
                                    <td> <?= $order['customer_name'] ?> </td>
                                    <td> <?= $order['customer_phone'] ?> </td>
                                    <td> <?= $order['order_date'] ?> </td>
                                    <td>
                                        <?php $status = strtolower(($order['order_status']));
                                        $badgeClass = 'secondary';
                                        if ($status === 'confirmed') $badgeClass = 'success';
                                        ?>
                                        <span class="badge bg-<?= $badgeClass ?>"> <?= $order['order_status'] ?> </span>
                                    </td>
                                    <td> <?= $order['payment_mode'] ?> </td>
                                    <td>
                                        <a href="order-view.php?tracking_no=<?= urlencode($order['tracking_no']) ?>" class="btn btn-sm btn-info">View</a>
                                        <a href="order-print-view.php?tracking_no=<?= urlencode($order['tracking_no']) ?>" class="btn btn-sm btn-warning">Print</a>
                                    </td>
                                </tr>

                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>
    </div>

</div>