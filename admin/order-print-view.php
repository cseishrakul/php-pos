<?php
include('../config/functions.php');
if (!isset($_GET['tracking_no'])) {
    die('Invalid tracking number');
}

$tracking_no = validate($_GET['tracking_no']);

$query = "SELECT o.*, c.name AS customer_name, c.email,c.phone FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.tracking_no = '$tracking_no' LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Order not found");
}

$order = mysqli_fetch_assoc($result);

$order_id = $order['id'];
$itemQuery = "SELECT oi.*, p.name AS product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = '$order_id'";

$items = mysqli_query($conn, $itemQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - <?= $tracking_no ?> </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.1/jspdf.umd.min.js" integrity="sha512-ad3j5/L4h648YM/KObaUfjCsZRBP9sAOmpjaT2BDx6u9aBrKFp7SbeHykruy83rxfmG42+5QqeL/ngcojglbJw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5" id="invoice">
        <div class="card shadow-md">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Invoice</h3>
                <span class="badge bg-info text-dark"> <?= $order['tracking_no'] ?> </span>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Customer Information</h5>
                        <p> <strong> <?= $order['customer_name'] ?> </strong> <br> <?= $order['email'] ?> <br> <?= $order['phone'] ?> </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h5>Order Details</h5>
                        <p> Invoice No: <strong> <?= $order['invoice_no'] ?> </strong> <br> Order Date: <?= date('d M Y', strtotime($order['order_date'])) ?> <br> Status: <?= $order['order_status'] ?> <br> Payment Mode: <?= $order['payment_mode'] ?> </p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-nordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Price (Tk)</th>
                                <th>Qty</th>
                                <th>Total (Tk)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $grandTotal = 0;
                            while ($item = mysqli_fetch_assoc($items)):
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
                            <?php endwhile;  ?>
                            <tr class="table-secondary fw-bold">
                                <td colspan="4" class="text-end"> Total Amount </td>
                                <td> <?= number_format($grandTotal, 2) ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-center mt-4 mb-0">Thank you for your order!</p>
            </div>

            <div class="card-footer text-end no-print">
                <button onclick="window.print()" class="btn btn-primary">Print</button>
                <button onclick="downloadPDF()" class="btn btn-success">Download PDF</button>
            </div>
        </div>
    </div>


    <script>
        function downloadPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');
            doc.html(document.getElementById('invoice'), {
                callback: function(pdf) {
                    pdf.save("invoice-<?= $tracking_no ?>.pdf");
                },
                margin: [20, 20, 20, 20],
                autoPaging: 'text',
                x: 0,
                y: 0,
                width: 595.28,
                windowWidth: 800
            });
        }
    </script>

</body>

</html>