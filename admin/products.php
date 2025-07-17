<?php include('includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Products / Staff</li>
        <a href="product-create.php" class="btn btn-primary ms-auto">Create Product +</a>
    </ol>

    <div class="card">
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php
            $products = getAll('products');
            if (!$products) {
                echo '<h4> Something went wrong! </h4>';
                return false;
            }
            if (mysqli_num_rows($products) > 0) {

            ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $item) : ?>
                                <tr>
                                    <td> <?= $item['id'] ?> </td>
                                    <td>
                                        <img src="../assets/uploads/products/<?= $item['image'] ?>" alt="" style="width:50px;height:50px">
                                    </td>
                                    <td> <?= $item['name'] ?> </td>
                                    <td>
                                        <?php if ($item['status'] == 1) {
                                            echo '<span class="badge bg-danger">Hidden</span>';
                                        } else {
                                            echo '<span class="badge bg-primary">Visible</span>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="product-edit.php?id=<?= $item['id'] ?>" class="btn btn-primary">Edit</a>
                                        <a href="product-delete.php?id=<?= $item['id'] ?>" class="btn btn-danger">Delete</a>
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