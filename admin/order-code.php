<?php
include('../config/functions.php');

if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}
if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}

if (isset($_POST['saveOrder'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1 ");

    if ($checkProduct) {
        if (mysqli_num_rows($checkProduct) > 0) {
            $row = mysqli_fetch_assoc(($checkProduct));
            if ($row['quantity'] < $quantity) {
                redirect('order-create.php', 'Only ' . $row['quantity'] . ' quantity available');
            }

            $productData = [
                'product_id' => $row['id'],
                'name' => $row['name'],
                'image' => $row['image'],
                'price' => $row['price'],
                'quantity' => $quantity
            ];

            if (!in_array($row['id'], $_SESSION['productItemIds'])) {
                array_push($_SESSION['productItemIds'], $row['id']);
                array_push($_SESSION['productItems'], $productData);
            } else {
                foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                    if ($prodSessionItem['product_id'] == $row['id']) {
                        $newQuantity = $prodSessionItem['quantity'] + $quantity;
                        $productData = [
                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'image' => $row['image'],
                            'price' => $row['price'],
                            'quantity' => $newQuantity
                        ];

                        $_SESSION['productItems'][$key] = $productData;
                        break;
                    }
                }
            }
        }
        redirect('order-create.php', 'Item added ' . $row['name']);
    } else {
        redirect('order-create.php', 'No product found');
    }
}




if (isset($_POST['increment']) || isset($_POST['decrement'])) {
    $productId = validate($_POST['product_id']);
    $currentQuantity = (int) validate(($_POST['quantity']));

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id = '$productId' LIMIT 1");

    if ($checkProduct && mysqli_num_rows($checkProduct) > 0) {
        $row = mysqli_fetch_assoc($checkProduct);
        $stockQuantity = (int) $row['quantity'];
    }
    if (isset($_POST['increment'])) {
        $newQuantity = $currentQuantity + 1;
    } elseif (isset($_POST['decrement'])) {
        $newQuantity = max(1, $currentQuantity - 1);
    }

    if ($newQuantity > $stockQuantity) {
        $newQuantity = $stockQuantity;
        $_SESSION['message'] = "Only $stockQuantity Items in stock! ";
    }

    $update = false;
    foreach ($_SESSION['productItems'] as $key => $item) {
        if ($item['product_id'] == $productId) {
            $_SESSION['productItems'][$key]['quantity'] = $newQuantity;
            $update = true;
            break;
        }
    }
    header("Location:order-create.php");
    exit();
}


if (isset($_POST['proceedToPlace'])) {
    $paymentMode = validate($_POST['payment_mode']);
    $cphone = validate($_POST['cphone']);
    if ($paymentMode == '' || $cphone == '') {
        redirect('order-create.php', 'Please select payment method and enter phone number!');
    }

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$cphone' LIMIT 1");

    if (mysqli_num_rows($checkCustomer) > 0) {
        $customer = mysqli_fetch_assoc($checkCustomer);

        $_SESSION['order_customer_id'] = $customer['id'];
        $_SESSION['customer_phone'] = $cphone;
        $_SESSION['payment_mode'] = $paymentMode;
        redirect('order-summary.php', 'Customer found.Proceeding to summary');
    } else {
        $_SESSION['new_customer_phone'] = $cphone;
        $_SESSION['payment_mode'] = $paymentMode;
        $_SESSION['show_add_customer_modal'] = true;

        redirect('order-create.php', 'Customer not found.Please add customer');
    }
}


if (isset($_POST['saveCustomer'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);

    $check = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone'");

    if (mysqli_num_rows($check) > 0) {
        $_SESSION['message'] = "Customer already exists";
    }

    $query = "INSERT INTO customers (name,email,phone) VALUES ('$name','$email','$phone')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $customer_id = mysqli_insert_id($conn);
        $_SESSION['order_customer_id'] = $customer_id;
        $payment_mode = $_SESSION['payment_mode'] ?? 'Cash Payment';
        $_SESSION['payment_mode'] = $payment_mode;
        unset($_SESSION['new_customer_phone']);
        unset($_SESSION['show_add_customer_modal']);
        header("Location:order-summary.php");
        exit();
    }else{
        $_SESSION['message'] = "Failed to add customer.";
        header("Location:order-create.php");
    }
}