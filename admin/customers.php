<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Customers / User</li>
        <a href="customer-create.php" class="btn btn-primary ms-auto">Create Customer +</a>
    </ol>

    <div class="card">
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php
            $customers = getAll('customers');
            if (!$customers) {
                echo '<h4> Something went wrong! </h4>';
                return false;
            }
            if (mysqli_num_rows($customers) > 0) {

            ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $item) : ?>
                                <tr>
                                    <td> <?= $item['id'] ?> </td>
                                    <td> <?= $item['name'] ?> </td>
                                    <td> <?= $item['email'] ?> </td>
                                    <td> <?= $item['phone'] ?> </td>
                                    <td>
                                        <?php if ($item['status'] == 1) {
                                            echo '<span class="badge bg-danger">Hidden</span>';
                                        }else{
                                            echo '<span class="badge bg-primary">Visible</span>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="customer-edit.php?id=<?= $item['id'] ?>" class="btn btn-primary">Edit</a>
                                        <a href="customer-delete.php?id=<?= $item['id'] ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
            ?>

                <tr>
                    <td colspan="4"> No record found! </td>
                </tr>
            <?php } ?>

        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>