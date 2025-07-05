<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Admins / Staff</li>
        <a href="admin-create.php" class="btn btn-primary ms-auto">Create Admin +</a>
    </ol>

    <div class="card">
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php
            $admins = getAll('admins');
            if (!$admins) {
                echo '<h4> Something went wrong! </h4>';
                return false;
            }
            if (mysqli_num_rows($admins) > 0) {

            ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $adminItem) : ?>
                                <tr>
                                    <td> <?= $adminItem['id'] ?> </td>
                                    <td> <?= $adminItem['name'] ?> </td>
                                    <td> <?= $adminItem['email'] ?> </td>
                                    <td> <?= $adminItem['phone'] ?> </td>
                                    <td>
                                        <a href="admin-edit.php?id=<?= $adminItem['id'] ?>" class="btn btn-primary">Edit</a>
                                        <a href="admin-delete.php?id=<?= $adminItem['id'] ?>" class="btn btn-danger">Delete</a>
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