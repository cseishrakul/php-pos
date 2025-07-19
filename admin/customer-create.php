<?php session_start(); ?>

<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Customers / User</li>
        <a href="customers.php" class="btn btn-primary ms-auto">Back</a>
    </ol>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Customer / User</h5>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label"> Name </label>
                        <input type="text" name="name" required class="form-control" placeholder="Enter your name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label"> Email </label>
                        <input type="email" name="email" required class="form-control" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label"> Phone Number </label>
                        <input type="text" name="phone" required class="form-control" placeholder="+8801XXXXXXX">
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="status" class="form-check-input" id="is_ban">
                            <label for="is_ban" class="form-check-label ms-2"> Status </label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary w-100" name="saveCustomer">Save Customer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>