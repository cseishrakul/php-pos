<?php session_start();
include('includes/header.php');
$customerId = checkParamId('id');
if (!is_numeric($customerId)) {
    echo '<h5> Invalid Id </h5>';
    exit;
}

$customerData = getById('customers', $customerId);
if (!$customerData || $customerData['status'] != 200) {
    echo '<h5> Customer not found! </h5>';
    exit;
}

$customer = $customerData['data'];
?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Customers / Users</li>
        <a href="customers.php" class="btn btn-primary ms-auto">Back</a>
    </ol>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Update Customer / user</h5>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <input type="hidden" name="customer_id" value="<?= $customer['id'] ?>">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label"> Name </label>
                        <input type="text" name="name" required class="form-control" placeholder="Enter your name" value="<?= $customer['name'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label"> Email </label>
                        <input type="email" name="email" required class="form-control" placeholder="example@email.com" value="<?= $customer['email'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label"> Phone Number </label>
                        <input type="text" name="phone" required class="form-control" placeholder="+8801XXXXXXX" value="<?= $customer['phone'] ?>">
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="status" class="form-check-input" id="is_ban" <?= $customer['status'] == true ? 'checked' : '' ?>>
                            <label for="is_ban" class="form-check-label ms-2"> Status </label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary w-100" name="updateCustomer">Update Customer</button>
                    </div>
                </div>


            </form>
        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>