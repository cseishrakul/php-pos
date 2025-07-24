<?php
session_start();
include('includes/header.php');


$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date']:"";
$payment_mode = isset($_GET['payment_mode']) ? $_GET['payment_mode']:"";

$conditions = [];

if($filter_date != ''){
    $safe_order = mysqli_real_escape_string($conn,$filter_date);
    $conditions[] ="DATE(o.order_date)  = '$safe_order' ";
}

if($payment_mode != ''){
     $safe_payment = mysqli_real_escape_string($conn,$payment_mode);
    $conditions[] ="o.payment_mode = '$safe_payment' ";
}

$whereSQL = '';
if(count($conditions) > 0){
    $whereSQL = "WHERE ".implode(' AND ',$conditions);
}

$query = "SELECT o.id, o.tracking_no, o.order_date, o.order_status,o.payment_mode,c.name AS customer_name,c.phone AS customer_phone FROM orders o JOIN customers c ON o.customer_id = c.id $whereSQL ORDER BY o.order_date DESC";

$result = mysqli_query($conn, $query);
?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Orders List</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Customers / User</li>
        <a href="order-create.php" class="btn btn-primary ms-auto">Create Order +</a>
    </ol>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"> <?= $_SESSION['message']; ?> </div>
    <?php endif ?>


    <div class="card shadow-sm">
        <div class="card-body">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <div class="table-responsive">
                    <form method="GET" class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label for="" class="form-label">Order Date</label>
                            <input type="date" name="filter_date" id="" class="form-control" value="<?= isset($_GET['filter_date']) ? htmlspecialchars($_GET['filter_date']) : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="" class="form-label">Payment Mode</label>
                            <select name="payment_mode" class="form-select" id="">
                                <option value=""> -- Select Payment Method -- </option>
                                <option value="Online Payment" <?= isset($_GET['payment_mode']) && $_GET['payment_mode'] == 'Online Payment' ? 'selected':'' ?>> Online Payment </option>
                                <option value="Cash Payment" <?= isset($_GET['payment_mode']) && $_GET['payment_mode'] == 'Cash Payment' ? 'selected':'' ?>> Cash Payment </option>
                            </select>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button class="btn btn-secondary" type="reset">Reset</button>
                        </div>
                    </form>
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