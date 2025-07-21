<?php
session_start();
include('includes/header.php');

if (!isset($_SESSION['order_customer_id'])) {
    $_SESSION['message'] = "Please select or add a customer first";
    header('Location:order-create.php');
    exit();
}

$company = [
    'name' => 'Pos solutions',
    'address' => 'Zindabazar Sylhet, Bangladesh',
    'phone' => '+880171010101'
];

$customer_id = $_SESSION['order_customer_id'];
$customerData = getById('customers', $customer_id);
$customer = $customerData['data'] ?? null;

if (!$customer) {
    $_SESSION['messae'] = "Customer not found!";
    header('Location:order-create.php');
    exit();
}

$invoice_no = 'INV-' . strtoupper(uniqid());
$invoice_date = date('Y-m-d');
$payment_mode = $_SESSION['payment_mode'] ?? 'N/A';
$ordered_products = $_SESSION['productItems'] ?? [];
?>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Order Summary</h4>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <h4 class="fw-bold"> <?= htmlspecialchars($company['name']) ?> </h4>
                <p class="mb-0"> <?= nl2br(htmlspecialchars($company['address'])) ?> </p>
                <p> <?= htmlspecialchars($company['phone']) ?> </p>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <h6 class="text-primary">Customer Details</h6>
                        <p class="mb-1"> <strong>Name: </strong> <?= $customer['name']; ?> </p>
                        <p class="mb-1"> <strong>Email: </strong> <?= $customer['email']; ?> </p>
                        <p class="mb-1"> <strong>Phone: </strong> <?= $customer['phone']; ?> </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <h6 class="text-primary">Invoice Info</h6>
                        <p class="mb-1"> <strong>Invoice No: </strong> <?= $invoice_no ?> </p>
                        <p class="mb-1"> <strong>Date: </strong> <?= $invoice_date ?> </p>
                        <p class="mb-1"> <strong>payment Mode: </strong> <?= $payment_mode ?> </p>
                    </div>
                </div>
            </div>
            <h6 class="text-primary mb-3 fw-bold">Products Ordered</h6>
            <?php if (count($ordered_products) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $grandTotal = 0;
                            foreach ($ordered_products as $index => $item): $lineTotal = $item['price'] * $item['quantity'];
                                $grandTotal += $lineTotal; ?>

                                <tr>
                                    <td> <?= $index + 1 ?> </td>
                                    <td> <?= $item['name'] ?> </td>
                                    <td> <?= number_format($item['price'], 2) ?> </td>
                                    <td> <?= $item['quantity'] ?> </td>
                                    <td> <?= number_format($lineTotal, 2) ?> </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="table-secondary fw-bold">
                                <td colspan="4" class="text-end"> Total Amount: </td>
                                <td> <?= number_format($grandTotal, 2) ?> Tk </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>

            <div class="text-end mt-4">
                <a href="order-create.php" class="btn btn-secondary"> Back to order </a>
                <a href="order-save.php" class="btn btn-primary"> Confirm order </a>
            </div>

        </div>
    </div>
</div>